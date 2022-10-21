<?php

namespace McArrowsmithPackages\ShopifyGraphQLClient;

use function json_decode;
use function json_encode;
use function json_last_error;
use McArrowsmithPackages\ShopifyGraphQLClient\Exceptions\JsonException;

class JsonHandler
{
    /**
     * @param mixed $value
     * @param int   $options
     *
     * @throws JsonException
     */
    public static function encode($value, $options = 0): string
    {
        $result = json_encode($value, $options);

        if (json_last_error() === JSON_ERROR_NONE) {
            return (string) $result;
        }

        throw JsonException::fromJsonErrorMessage();
    }

    /**
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     *
     * @throws JsonException
     *
     * @return mixed
     */
    public static function decode(string $json, $assoc = false, $depth = 512, $options = 0)
    {
        $result = json_decode($json, $assoc, $depth, $options);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $result;
        }

        throw JsonException::fromJsonErrorMessage();
    }
}
