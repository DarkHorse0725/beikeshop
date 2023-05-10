<?php
/**
 * MenusController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-07-21 10:00:25
 * @modified   2022-07-21 10:00:25
 */

namespace Plugin\LatestProducts\Controllers;

use Beike\Repositories\ProductRepo;
use Beike\Shop\Http\Controllers\Controller;
use Beike\Shop\Http\Resources\ProductSimple;

class MenusController extends Controller
{
    public function getRoutes(): array
    {
        return [
            'method'     => __METHOD__,
            'route_list' => [],
        ];
    }

    public function latestProducts()
    {
        $products = ProductRepo::getBuilder(
            [
                'active' => 1,
                'sort'   => 'created_at',
                'order'  => 'desc',
            ])
            ->whereHas('masterSku')
            ->with('inCurrentWishlist')
            ->orderByDesc('created_at')
            ->paginate(perPage());

        $data = [
            'products' => $products,
            'items'    => ProductSimple::collection($products)->jsonSerialize(),
        ];

        return view('LatestProducts::shop.latest_products', $data);
    }
}
