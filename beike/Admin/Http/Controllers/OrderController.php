<?php
/**
 * OrderController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-07-05 10:45:26
 * @modified   2022-07-05 10:45:26
 */

namespace Beike\Admin\Http\Controllers;

use Beike\Admin\Http\Resources\OrderSimple;
use Beike\Models\Order;
use Beike\Models\OrderShipment;
use Beike\Repositories\OrderRepo;
use Beike\Services\ShipmentService;
use Beike\Services\StateMachineService;
use Beike\Shop\Http\Resources\Account\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 获取订单列表
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $orders = OrderRepo::filterOrders($request->all());
        $data   = [
            'orders'   => OrderList::collection($orders),
            'statuses' => StateMachineService::getAllStatuses(),
        ];
        $data = hook_filter('admin.order.index.data', $data);

        return view('admin::pages.orders.index', $data);
    }

    /**
     * 导出订单列表
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function export(Request $request)
    {
        try {
            $orders = OrderRepo::filterAll($request->all());
            $items  = OrderSimple::collection($orders)->jsonSerialize();
            $items  = hook_filter('admin.order.export.data', $items);

            return $this->downloadCsv('orders', $items, 'order');
        } catch (\Exception $e) {
            return redirect(admin_route('orders.index'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * 查看单个订单
     *
     * @param Request $request
     * @param Order   $order
     * @return mixed
     * @throws \Exception
     */
    public function show(Request $request, Order $order)
    {
        $order->load(['orderTotals', 'orderHistories', 'orderShipments']);
        $data             = hook_filter('admin.order.show.data', ['order' => $order, 'html_items' => []]);
        $data['statuses'] = StateMachineService::getInstance($order)->nextBackendStatuses();
        $data             = hook_filter('admin.order.show.data', $data);

        return view('admin::pages.orders.form', $data);
    }

    /**
     * 更新订单状态,添加订单更新日志
     *
     * @param Request $request
     * @param Order   $order
     * @return array
     * @throws \Throwable
     */
    public function updateStatus(Request $request, Order $order)
    {
        $status  = $request->get('status');
        $comment = $request->get('comment');
        $notify  = $request->get('notify');

        $shipment = ShipmentService::handleShipment(\request('express_code'), \request('express_number'));

        $stateMachine = new StateMachineService($order);
        $stateMachine->setShipment($shipment)->changeStatus($status, $comment, $notify);

        $orderStatusData = $request->all();

        hook_action('admin.order.update_status.after', $orderStatusData);

        return json_success(trans('common.updated_success'));
    }

    /**
     * 更新发货信息
     */
    public function updateShipment(Request $request, Order $order, int $orderShipmentId): array
    {
        $data          = $request->all();
        $orderShipment = OrderShipment::query()->where('order_id', $order->id)->findOrFail($orderShipmentId);
        ShipmentService::updateShipment($orderShipment, $data);
        hook_action('admin.order.update_shipment.after', [
            'request_data' => $data,
            'shipment'     => $orderShipment,
        ]);

        return json_success(trans('common.updated_success'));
    }
}
