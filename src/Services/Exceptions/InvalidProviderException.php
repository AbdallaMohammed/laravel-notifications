<?php

namespace Elnooronline\Notifications\Services\Exceptions;

final class InvalidProviderException extends \Exception
{
    /**
     * @param string $provider
     */
    public function __construct(string $provider)
    {
        parent::__construct(
            sprintf(
                'Invalid call for "%s" provider.',
                $provider
            )
        );
    }
}
