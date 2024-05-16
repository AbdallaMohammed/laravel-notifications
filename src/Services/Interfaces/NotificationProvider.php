<?php

namespace Elnooronline\Notifications\Services\Interfaces;

use Elnooronline\Notifications\Services\Providers\Notifications\BaseNotification;

interface NotificationProvider
{
    public function setData(array $data): void;

    public function toArray(): array;

    public function getNotifiables(): array;

    public function toNotification(): BaseNotification;
}
