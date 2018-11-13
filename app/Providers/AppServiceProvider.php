<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Yansongda\Pay\Log;
use Yansongda\Pay\Pay;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('alipay', function () {
            $config = config('pay.alipay');
//            $config['notify_url'] = route('payment.alipay.notify');
            $config['notify_url'] = 'http://c01d3a61.ngrok.io/payment/alipay/notify';
            $config['return_url'] = route('payment.alipay.return');
            if (app()->environment() !== 'production') {
                $config['mode'] = 'dev';
                $config['log']['level'] = Logger::DEBUG;
            } else {
                $config['log']['level'] = Logger::WARNING;
            }

            return Pay::alipay($config);
        });
    }
}
