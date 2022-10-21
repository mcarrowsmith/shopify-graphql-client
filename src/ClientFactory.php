<?php

namespace McArrowsmithPackages\ShopifyGraphQLClient;

class ClientFactory
{
    public static function make(
        string $shop,
        string $apiToken,
        string $apiVersion = '2022-07'
    ) {
        return new Client(
            new \GuzzleHttp\Client,
            $shop,
            $apiToken,
            $apiVersion
        );
    }
}
