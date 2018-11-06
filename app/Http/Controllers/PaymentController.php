<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payByAlipay(Order $order, Request $request)
    {
        $this->authorize('own', $order);

        if ($order->paid_at || $order->closed) {
            throw new InvalidRequestException('当前订单不支持支付');
        }

        return app('alipay')->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount,
            'subject' => '支付Shop订单: '.$order->no,
        ]);
    }

    // 同步通知
    public function alipayReturn()
    {
        try {
            app('alipay')->verify();
        } catch (\Exception $exception) {
            return view('pages.error', ['msg' => '数据校验失败']);
        }

        return view('pages.success', ['msg' => '付款成功']);
    }

    // 异步通知
    public function alipayNotify()
    {
        $data = app('alipay')->verify();

        $order = Order::where('no', $data->out_trade_no)->first();

        if (!$order) {
            return 'fail';
        }

        if ($order->paid_at) {
            return app('alipay')->success();
        }

        $order->update([
            'paid_at' => Carbon::now(),
            'payment_method' => 'alipay',
            'payment_no' => $data->trade_no,
        ]);

        return app('alipay')->success();
    }
}
