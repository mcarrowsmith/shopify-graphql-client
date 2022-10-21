<?php

namespace McArrowsmithPackages\ShopifyGraphQLClient\Exceptions;

use Exception;

final class ShopifyGraphQLErrorException extends Exception
{
    private $debug = [];

    public static function fromErrorData(array $error): self
    {
        $first = $error[0];

        $instance        = new self($first['message']);
        $instance->debug = $error;

        return $instance;
    }

    public function debug(): array
    {
        return $this->debug;
    }
}
