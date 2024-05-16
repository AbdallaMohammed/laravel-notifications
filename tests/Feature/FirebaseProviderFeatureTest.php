<?php

namespace Elnooronline\Notifications\Tests\Feature;

use Elnooronline\Notifications\Services\Providers\Notifications\FirebaseNotification;
use Elnooronline\Notifications\Support\Notifications;
use Elnooronline\Notifications\Tests\Model\User;
use Elnooronline\Notifications\Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class FirebaseProviderFeatureTest extends TestCase
{
    public function testSendFirebaseNotification()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $model = User::forceCreate([
            'name' => 'Hello',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
        ]);

        $notification = Notifications::make();

        $instance = $notification
            ->provider('firebase')
            ->title('Firebase !')
            ->body('A firebase notification sample')
            ->notifiable($model);

        $instance->syncQueue();

        $chain = $notification->toChain();

        $chain->sendAll();

        Notification::assertSentTo($model, FirebaseNotification::class);
    }
}
