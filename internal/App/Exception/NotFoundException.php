<?php

namespace Albuca\DiPhp\App\Exception;

class NotFoundException extends \Exception implements \Psr\Container\NotFoundExceptionInterface
{
    private const NOT_FOUND_MESSAGE = 'Could not resolve definitions for %s';

    public function __construct(string $class, ?\Throwable $previous = null)
    {
        $formattedMessage = sprintf(self::NOT_FOUND_MESSAGE, $class);

        parent::__construct($formattedMessage, 500, $previous);
    }
}