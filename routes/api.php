<?php

use Illuminate\Support\Facades\Route;
use Modules\Isetting\Http\Controllers\Api\SettingApiController;

// add-use-controller


Route::prefix('/isetting/v1')->group(function () {
    Route::apiCrud([
        'module' => 'isetting',
        'prefix' => 'settings',
        'controller' => SettingApiController::class,
        'permission' => 'isetting.settings',
        'middleware' => ['index' => []],
        'customRoutes' => [ // Include custom routes if needed
            [
                'method' => 'post', // get,post,put....
                'path' => '/set', // Route Path
                'uses' => 'set', //Name of the controller method to use
                'middleware' => [] //TODO: put permission | if not set up middleware, auth:api will be the default
            ],
            [
                'method' => 'get', // get,post,put....
                'path' => '/get/all', // Route Path
                'uses' => 'getAll', //Name of the controller method to use
                'middleware' => []
            ],
        ]
    ]);
    // append

});
