<?php

namespace Elnooronline\Notifications\Tests\Feature;

use Elnooronline\Notifications\Support\Notifications;
use Elnooronline\Notifications\Tests\Model\User;
use Elnooronline\Notifications\Tests\TestCase;
use Illuminate\Support\Facades\Notification;

class FirebaseProviderFeatureTest extends TestCase
{
    public function testSendFirebaseNotification()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $model = new User();

        $notification = Notifications::make();

        $instance = $notification
            ->provider('firebase')
            ->title('Firebase !')
            ->body('A firebase notification sample')
            ->notifiable($model)
            ->syncQueue();

        $chain = $notification->toChain();

        $chain->sendAll();

        // Notification::assertSentTo($model, $instance);
    }
}
