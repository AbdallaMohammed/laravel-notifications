<?php

namespace Elnooronline\Notifications\Services;

use Elnooronline\Notifications\Services\Interfaces\NotificationProvider;
use Elnooronline\Notifications\Services\Providers\Notifications\FirebaseNotification;
use Illuminate\Support\Facades\Notification;

class SendService
{
    private NotificationProvider $provider;

    /**
     * Send notification.
     *
     * @return void
     */
    public function send()
    {
        Notification::send(
            $this->provider->getNotifiables(),
            new FirebaseNotification($this->provider)
        );
    }

    /**
     * @param NotificationProvider $provider
     * @return $this
     */
    public function setProvider(NotificationProvider $provider)
    {
        $this->provider = $provider;

        return $this;
    }
}
