<?php

namespace Elnooronline\Notifications\Services\Interfaces;

interface NotificationProvider
{
    public function setData(array $data): void;

    public function getData(): array;
}
