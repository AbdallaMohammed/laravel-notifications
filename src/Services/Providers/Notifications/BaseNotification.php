<?php

namespace Elnooronline\Notifications\Services\Providers\Notifications;

use Elnooronline\Notifications\Services\Providers\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

abstract class BaseNotification extends Notification
{
    use Queueable;

    /**
     * @param Provider
     */
    protected Provider $provider;

    /**
     * BaseNotification Constructor.
     */
    public function __construct(Provider $provider)
    {
        $this->provider = $provider;

        $this->setQueueConfig();
    }

    /**
     * Notification channels.
     */
    abstract public function via(): array;

    /**
     * Set queue configuration.
     *
     * @return void
     */
    protected function setQueueConfig()
    {
        if ($this->provider->getConfig()->has('queue')) {
            $this->onQueue($this->provider->getConfig()->get('queue'));
        }
    }
}
