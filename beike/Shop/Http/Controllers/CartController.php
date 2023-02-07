<?php

namespace Beike\Shop\Http\Controllers;

use Beike\Models\ProductSku;
use Beike\Shop\Http\Requests\CartRequest;
use Beike\Shop\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $data = [
            'data' => CartService::reloadData(),
        ];

        $data = hook_filter('cart.index.data', $data);

        return view('cart/cart', $data);
    }

    /**
     * 选中购物车商品
     *
     * POST /carts/select {cart_ids:[1, 2]}
     * @param Request $request
     * @return array
     */
    public function select(Request $request): array
    {
        $cartIds  = $request->get('cart_ids');
        $customer = current_customer();
        CartService::select($customer, $cartIds);

        $data = CartService::reloadData();

        $data = hook_filter('cart.select.data', $data);

        return json_success(trans('common.updated_success'), $data);
    }

    /**
     * POST /carts {sku_id:1, quantity: 2}
     * 创建购物车
     *
     * @param CartRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function store(CartRequest $request)
    {
        $skuId    = $request->sku_id;
        $quantity = $request->quantity       ?? 1;
        $buyNow   = (bool) $request->buy_now ?? false;
        $customer = current_customer();

        $sku = ProductSku::query()
            ->whereRelation('product', 'active', '=', true)
            ->findOrFail($skuId);

        $cart = CartService::add($sku, $quantity, $customer);
        if ($buyNow) {
            CartService::select($customer, [$cart->id]);
        }

        $cart = hook_filter('cart.store.data', $cart);

        return json_success(trans('shop/carts.added_to_cart'), $cart);
    }

    /**
     * PUT /carts/{cart_id} {sku_id:1, quantity: 2}
     * @param CartRequest $request
     * @param $cartId
     * @return array
     */
    public function update(CartRequest $request, $cartId): array
    {
        $customer = current_customer();
        $quantity = (int) $request->get('quantity');
        CartService::updateQuantity($customer, $cartId, $quantity);

        $data = CartService::reloadData();

        $data = hook_filter('cart.update.data', $data);

        return json_success(trans('common.updated_success'), $data);
    }

    /**
     * DELETE /carts/{cart_id}
     * @param Request $request
     * @param $cartId
     * @return array
     */
    public function destroy(Request $request, $cartId): array
    {
        $customer = current_customer();
        CartService::delete($customer, $cartId);

        $data = CartService::reloadData();

        $data = hook_filter('cart.destroy.data', $data);

        return json_success(trans('common.deleted_success'), $data);
    }

    /**
     * 右上角购物车
     * @return mixed
     */
    public function miniCart()
    {
        $carts      = CartService::list(current_customer());
        $reloadData = CartService::reloadData($carts);

        $data['html']         = view('cart/mini', $reloadData)->render();
        $data['quantity']     = $reloadData['quantity'];
        $data['quantity_all'] = $reloadData['quantity_all'];

        $data = hook_filter('cart.mini_cart.data', $data);

        return json_success(trans('common.success'), $data);
    }
}
