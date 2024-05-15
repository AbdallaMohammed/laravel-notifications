<?php

namespace Elnooronline\Notifications\Support;

use Elnooronline\Notifications\Http\Controllers\FcmTokenController;
use Elnooronline\Notifications\Services\NotificationService;
use Illuminate\Support\Facades\App;

class Notifications
{
    /**
     * @return NotificationService
     */
    public static function make()
    {
        return new NotificationService(config('elnooronline-notifications.providers'));
    }

    /**
     * Register routes.
     *
     * @param $middleware
     * @return void
     */
    public static function routes($middleware = 'auth:api'): void
    {
        $router = App::make('router');

        $router->middleware($middleware)
            ->group(function ($router) {
                $router->post('fcm/update', [FcmTokenController::class, 'update']);
                $router->delete('fcm/tokens/{token?}', [FcmTokenController::class, 'destroy']);
            });
    }
}
