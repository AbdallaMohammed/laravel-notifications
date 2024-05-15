<?php

namespace Elnooronline\Notifications\Services;

use Elnooronline\Notifications\Services\Exceptions\InvalidMethodException;
use Elnooronline\Notifications\Services\Exceptions\InvalidProviderException;
use Elnooronline\Notifications\Services\Interfaces\NotificationProvider;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * @var Collection
     */
    protected Collection $providers;

    /**
     * @var NotificationProvider|null
     */
    private $currentProvider = null;

    /**
     * @var array
     */
    protected array $sendChain = [];

    protected ProviderConfig $config;

    /**
     * NotificationService Constructor.
     *
     * @param array $providers
     */
    public function __construct(array $providers)
    {
        $this->setProviders($providers);
        $this->setDefaultConfig();
    }

    /**
     * @param string $provider
     * @return $this
     * @throws InvalidProviderException
     */
    public function provider(string $provider)
    {
        $this->providersExistsOrFall($provider);
        $this->saveCurrentProviderState();

        $provider = $this->providers->get($provider);
        $this->currentProvider = new $provider($this->config);

        return $this;
    }

    /**
     * @return ChainService
     */
    public function toChain()
    {
        $this->saveCurrentProviderState();

        return new ChainService($this->sendChain);
    }

    /**
     * @return void
     */
    protected function setDefaultConfig()
    {
        $this->config = new ProviderConfig(config('elnooronline-notifications.provider'));
    }

    /**
     * @param string $provider
     * @return bool
     * @throws InvalidProviderException
     */
    protected function providersExistsOrFall(string $provider)
    {
        if (! $this->providers->get($provider)) {
            throw new InvalidProviderException($provider);
        }

        if (! class_exists($this->providers->get($provider))) {
            throw new InvalidProviderException($provider);
        }

        return true;
    }

    /**
     * Save current provider state to be sent or queued later.
     *
     * @return void
     */
    protected function saveCurrentProviderState()
    {
        if (! $this->currentProvider) {
            return;
        }

        $this->sendChain[] = (new SendService())->setProvider($this->currentProvider);
    }

    /**
     * @param array $providers
     * @return void
     */
    protected function setProviders(array $providers)
    {
        $this->providers = collect($providers);
    }

    protected function resetSendChain()
    {
        $this->sendChain = [];
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     * @throws InvalidMethodException
     */
    public function __call(string $method, array $args)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$args);
        }

        if ($this->currentProvider && method_exists($this->currentProvider, $method)) {
            return $this->currentProvider->{$method}(...$args);
        }

        throw new InvalidMethodException($method);
    }
}
