<?php

namespace Elnooronline\Notifications\Services;

use Illuminate\Support\Collection;

class ChainService
{
    /**
     * @var SendService[]
     */
    private Collection $chain;

    /**
     * @param array $chain
     */
    public function __construct(array $chain)
    {
        $this->setChain($chain);
    }

    /**
     * @param $notifiables
     * @return $this
     */
    public function notifiables($notifiables)
    {
        $this->chain->each(fn ($interface) => $interface->setNotifiables($notifiables));

        return $this;
    }

    /**
     * @return $this
     */
    public function sendAll()
    {
        if ($this->chain->isEmpty()) {
            return $this;
        }

        foreach ($this->chain->toArray() as $interface) {
            $interface->send();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function sendFirst()
    {
        optional($this->chain->first())->send();

        return $this;
    }

    /**
     * @return $this
     */
    public function sendLast()
    {
        optional($this->chain->last())->send();

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->chain->count();
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->chain->isEmpty();
    }

    /**
     * @param array $chain
     * @return void
     */
    private function setChain(array $chain)
    {
        $this->chain = collect($chain)
            ->filter(fn ($interface) => $interface instanceof SendService);
    }
}
