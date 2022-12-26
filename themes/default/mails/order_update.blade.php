@extends('layout.mail')

@section('content')
  <tbody>
    <tr style="font-weight:300">
      <td style="width:3.2%;max-width:30px;"></td>
      <td style="max-width:480px;text-align:left;">
        <h1 style="font-size: 20px; line-height: 36px; margin: 0px 0px 22px;">
          {{ __('mail.order_update') }}
        </h1>
        <p style="font-size:14px;color:#333; line-height:24px; margin:0;">
          {{ __('mail.customer_name', ['name' => $order->customer_name]) }}
        </p>
        <p style="line-height: 24px; margin: 6px 0px 0px; overflow-wrap: break-word; word-break: break-all;">
          <span style="color: rgb(51, 51, 51); font-size: 14px;">{{ __('mail.order_update_status', ['number' => $order->number]) }}：
            <span style="font-weight: bold;">{{ __("common.order.{$order->status}") }}</span>
          </span>
        </p>

        <p style="font-size: 13px;font-weight:bold;margin-bottom:6px;color: #333;">{{ __('shop/account.order.order_info.order_items') }}：</p>
        <table style="width:100%;font-weight:300;margin-top:10px; margin-bottom:10px;border-collapse:collapse; ">
          <thead>
            <tr>
              <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px;width: 80px;text-align:center">{{ __('product.image') }}</td>
              <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px">{{ __('product.name') }}</td>
              <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px">{{ __('order.product_quantity') }}</td>
              <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px">{{ __('product.price') }}</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->orderProducts as $product)
            <tr>
              <td style="border: 1px solid #eee;padding:4px;text-align:center"><img style="width: 60px; height: 60px;" src="{{ image_origin($product->image) }}"></td>
              <td style="font-size:12px; border: 1px solid #eee; width: 50%;padding:4px;">{{ $product->name }}</td>
              <td style="border: 1px solid #eee;padding:4px;font-size: 13px;">{{ $product->quantity }}</td>
              <td style="border: 1px solid #eee;padding:4px;font-size: 13px;">{{ currency_format($product->price, $order->currency_code, $order->currency_value) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>

        @if ($order->orderShipments->count())
          <p style="font-size: 13px;font-weight:bold;margin-bottom:6px;color: #333;">{{ __('order.order_shipments') }}</p>
          <table style="width:100%;font-weight:300;margin-top:10px; margin-bottom:10px;border-collapse:collapse; ">
            <thead class="">
              <tr>
                <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px">{{ __('order.express_company') }}</td>
                <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px">{{ __('order.express_number') }}</td>
                <td style="font-size:13px;border: 1px solid #eee; background-color: #f8f9fa;padding: 7px 4px">{{ __('order.history_created_at') }}</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->orderShipments as $ship)
              <tr>
                <td style="border: 1px solid #eee;padding:4px;font-size: 13px;">{{ $ship->express_company }}</td>
                <td style="border: 1px solid #eee;padding:4px;font-size: 13px;">{{ $ship->express_number }}</td>
                <td style="border: 1px solid #eee;padding:4px;font-size: 13px;">{{ $ship->created_at }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @endif

        <dl style="font-size: 14px; color: rgb(51, 51, 51); line-height: 18px;">
          <dd style="margin: 0px 0px 6px; padding: 0px; font-size: 12px; line-height: 22px;">
            <p style="font-size: 14px; line-height: 26px; word-wrap: break-word; word-break: break-all; margin-top: 32px;">
              {{ __('mail.sincerely') }}
              <br>
              <strong>{{ config('app.name') }} {{ __('mail.team') }}</strong>
            </p>
          </dd>
        </dl>
      </td>
      <td style="width:3.2%;max-width:30px;"></td>
    </tr>
  </tbody>
@endsection
