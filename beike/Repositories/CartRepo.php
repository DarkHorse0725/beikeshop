<?php
/**
 * CartRepo.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-07-04 17:14:14
 * @modified   2022-07-04 17:14:14
 */

namespace Beike\Repositories;

use Beike\Models\Cart;
use Beike\Models\CartProduct;
use Beike\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CartRepo
{
    /**
     * 创建购物车
     *
     * @param $customer
     * @return Cart
     */
    public static function createCart($customer)
    {
        if (is_numeric($customer)) {
            $customer = Customer::query()->find($customer);
        }
        $customerId = $customer->id ?? 0;
        $sessionId  = session()->getId();
        if ($customerId) {
            $cart = Cart::query()->where('customer_id', $customerId)->first();
        } else {
            $cart = Cart::query()->where('session_id', $sessionId)->first();
        }
        $defaultAddress   = AddressRepo::listByCustomer($customer)->first();
        $defaultAddressId = $defaultAddress->id ?? 0;

        if (empty($cart)) {
            $shippingMethod     = PluginRepo::getShippingMethods()->first();
            $paymentMethod      = PluginRepo::getPaymentMethods()->first();
            $shippingMethodCode = $shippingMethod->code ?? '';
            $cart               = Cart::query()->create([
                'customer_id'          => $customerId,
                'session_id'           => $sessionId,
                'shipping_address_id'  => $defaultAddressId,
                'shipping_method_code' => $shippingMethodCode ? $shippingMethodCode . '.0' : '',
                'payment_address_id'   => $defaultAddressId,
                'payment_method_code'  => $paymentMethod->code ?? '',
            ]);
        } else {
            if ($cart->shipping_address_id == 0 || empty(AddressRepo::find($cart->shipping_address_id))) {
                $cart->shipping_address_id = $defaultAddressId;
            }
            if ($cart->payment_address_id == 0 || empty(AddressRepo::find($cart->payment_address_id))) {
                $cart->payment_address_id = $defaultAddressId;
            }
            $cart->save();
        }
        $cart->loadMissing(['shippingAddress', 'paymentAddress']);
        $cart->extra                  = json_decode($cart->extra, true);
        $cart->guest_shipping_address = json_decode($cart->guest_shipping_address, true);
        $cart->guest_payment_address  = json_decode($cart->guest_payment_address, true);

        return $cart;
    }

    /**
     * 清空购物车以及购物车已选中商品
     *
     * @param $customer
     */
    public static function clearSelectedCartProducts($customer)
    {
        if (is_numeric($customer)) {
            $customer = Customer::query()->find($customer);
        }
        $customerId = $customer->id ?? 0;
        if ($customer) {
            Cart::query()->where('customer_id', $customerId)->delete();
        } else {
            Cart::query()->where('session_id', session()->getId())->delete();
        }
        self::selectedCartProductsBuilder($customerId)->delete();
    }

    /**
     * 获取已选中购物车商品列表
     *
     * @param $customerId
     * @return Builder[]|Collection
     */
    public static function selectedCartProducts($customerId)
    {
        return self::selectedCartProductsBuilder($customerId)->get();
    }

    /**
     * 已选中购物车商品 builder
     *
     * @param $customerId
     * @return Builder
     */
    public static function selectedCartProductsBuilder($customerId): Builder
    {
        return self::allCartProductsBuilder($customerId)->where('selected', true);
    }

    /**
     * 获取所有购物车商品列表
     *
     * @param $customerId
     * @return Builder[]|Collection
     */
    public static function allCartProducts($customerId)
    {
        return self::allCartProductsBuilder($customerId)->get();
    }

    /**
     * 当前购物车所有商品 builder
     *
     * @param $customerId
     * @return Builder
     */
    public static function allCartProductsBuilder($customerId): Builder
    {
        $builder =  CartProduct::query()
            ->with(['product.description', 'sku.product.description']);
        if ($customerId) {
            $builder->where('customer_id', $customerId);
        } else {
            $builder->where('session_id', session()->getId());
        }
        $builder->orderByDesc('id');

        return $builder;
    }

    public static function mergeGuestCart($customer, $guestCartProducts)
    {
        $guestCartProductSkuIds = $guestCartProducts->pluck('product_sku_id');
        self::allCartProductsBuilder($customer->id)->whereIn('product_sku_id', $guestCartProductSkuIds)->delete();

        foreach ($guestCartProducts as $cartProduct) {
            $cartProduct->customer_id = $customer->id;
            $cartProduct->save();
        }

    }
}
