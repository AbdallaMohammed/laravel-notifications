<?php

namespace Elnooronline\Notifications\Services\Providers\Traits;

trait HasMagicCall
{
    /**
     * @param string $method
     * @param array $args
     * @return mixed
     * @throws \Elnooronline\Notifications\Services\Exceptions\InvalidMethodException
     */
    public function __call(string $method, array $args)
    {
        if (method_exists($this, $method)) {
            return $this->{$method}(...$args);
        }

        if (method_exists($this->fcmMessage, $method)) {
            return $this->fcmMessage->{$method}(...$args);
        }

        return parent::__call($method, $args);
    }
}
