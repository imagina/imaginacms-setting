<?php

namespace Modules\Setting\Providers;

use Modules\Core\Providers\RoutingServiceProvider as CoreRoutingServiceProvider;

class RouteServiceProvider extends CoreRoutingServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\Setting\Http\Controllers';

    protected function getFrontendRoute(): string
    {
        return false;
    }

    protected function getBackendRoute(): string
    {
        return __DIR__.'/../Http/backendRoutes.php';
    }

    protected function getApiRoute(): string
    {
        return false;
    }
}
