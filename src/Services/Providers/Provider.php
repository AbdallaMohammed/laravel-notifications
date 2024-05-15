<?php

namespace Elnooronline\Notifications\Services\Providers;

use Elnooronline\Notifications\Services\Providers\Traits\HasNotifiables;
use Elnooronline\Notifications\Services\Exceptions\InvalidMethodException;
use Elnooronline\Notifications\Services\ProviderConfig;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

abstract class Provider extends Notification
{
    use HasNotifiables;
    use Queueable;

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

    abstract public function channel();

    /**
     * @return mixed
     */
    public function via()
    {
        return $this->channel();
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
    protected function getConfig(): array
    {
        return $this->config->toArray();
    }

    /**
     * @return $this
     */
    public function toNotification()
    {
        $config = $this->getConfig();

        if ($config['queue']) {
            $this->onQueue($config['queue']);
        }

        return $this;
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
