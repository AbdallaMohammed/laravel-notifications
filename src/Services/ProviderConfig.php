<?php

namespace Elnooronline\Notifications\Services;

use Elnooronline\Notifications\Services\Enums\QueueEnum;

class ProviderConfig
{
    /**
     * @var array
     */
    protected array $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $queue
     * @return ProviderConfig
     */
    public function toQueue(string $queue)
    {
        $this->config['queue'] = $queue;

        return $this;
    }

    /**
     * @return ProviderConfig
     */
    public function syncQueue()
    {
        $this->toQueue(QueueEnum::SYNC);

        return $this;
    }

    /**
     * @return ProviderConfig
     */
    public function databaseQueue()
    {
        $this->toQueue(QueueEnum::DATABASE);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->config;
    }
}
