<?php

namespace Elnooronline\Notifications\Services;

use Elnooronline\Notifications\Services\Providers\Provider;
use Illuminate\Support\Facades\Notification;

class SendService
{
    private Provider $provider;

    /**
     * Send notification.
     *
     * @return void
     */
    public function send()
    {
        Notification::send(
            $this->provider->getNotifiables(),
            $this->provider->toNotification()
        );
    }

    /**
     * @param Provider $provider
     * @return $this
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;

        return $this;
    }
}
