<?php

namespace Elnooronline\Notifications\Services\Providers;

use Elnooronline\Notifications\Services\Providers\Traits\HasNotifiables;
use Elnooronline\Notifications\Services\Exceptions\InvalidMethodException;
use Elnooronline\Notifications\Services\Interfaces\NotificationProvider;
use Elnooronline\Notifications\Services\ProviderConfig;
use Elnooronline\Notifications\Services\Providers\Notifications\BaseNotification;
use Illuminate\Support\Arr;

abstract class Provider implements NotificationProvider
{
    use HasNotifiables;

    protected $notification;

    /**
     * @var array
     */
    protected array $data = [];

    private array $notifiables = [];

    /**
     * @var ProviderConfig|null
     */
    protected ProviderConfig $config;

    /**
     * @param ProviderConfig|null $config
     */
    public function __construct(ProviderConfig $config = null)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function get($key, $default = null)
    {
        // TODO: convert to BagClass
        return Arr::get($this->toArray(), $key, $default);
    }

    /**
     * Update saved data.
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    protected function getConfig(): ProviderConfig
    {
        return $this->config;
    }

    public function toNotification(): BaseNotification
    {
        if (! $this->notification || ! class_exists($this->notification)) {
            throw new \Exception('Cannot invoke notification without assign it');
        }

        $class = $this->notification;

        return new $class($this);
    }

    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws InvalidMethodException
     */
    public function __call(string $method, array $args)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$args);
        }

        if ($this->config && method_exists($this->config, $method)) {
            return $this->config->{$method}(...$args);
        }

        throw new InvalidMethodException($method);
    }
}
