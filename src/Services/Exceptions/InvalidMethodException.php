<?php

namespace Elnooronline\Notifications\Services\Exceptions;

final class InvalidMethodException extends \Exception
{
    /**
     * @param string $method
     */
    public function __construct(string $method)
    {
        parent::__construct(
            sprintf(
                'Cannot call provider method with invalid name "%s"',
                $method,
            ),
        );
    }
}
