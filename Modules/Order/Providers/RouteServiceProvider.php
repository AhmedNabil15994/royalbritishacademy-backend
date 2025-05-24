<?php

namespace Modules\Order\Providers;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $module_name = 'Order';

    protected $frontend_routes = [
        'routes.php',
    ];

    protected $dashboard_routes = [
        'orders.php',
        'order-statuses.php',
    ];

    protected $api_routes = [

        'orders.php',
    ];


    protected function frontendGroups()
    {
        return [
            'middleware' => config('core.route-middleware.frontend.guest'),
            'prefix' => LaravelLocalization::setLocale() . config('core.route-prefix.frontend')
        ];
    }

    protected function dashboardGroups()
    {
        return [
            'middleware' => config('core.route-middleware.dashboard.auth'),
            'prefix' => LaravelLocalization::setLocale() . config('core.route-prefix.dashboard')
        ];
    }

    protected function apiGroups()
    {
        return [
            'middleware' => config('core.route-middleware.api.guest'),
            'prefix' => config('core.route-prefix.api')
        ];
    }
}
