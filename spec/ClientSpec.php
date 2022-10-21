<?php

namespace spec\McArrowsmithPackages\ShopifyGraphQLClient;

use GuzzleHttp\ClientInterface;
use McArrowsmithPackages\ShopifyGraphQLClient\Client;
use McArrowsmithPackages\ShopifyGraphQLClient\Exceptions\ShopifyGraphQLErrorException;
use McArrowsmithPackages\ShopifyGraphQLClient\JsonHandler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ClientSpec extends ObjectBehavior
{
    const SHOPIFY_SHOP = 'example.myshopify.com';
    const SHOPIFY_API_VERSION = '2022-07';
    const SHOPIFY_API_TOKEN = 'fake-shopify-token';

    function let(
        ClientInterface $http,
        ResponseInterface $httpResponse,
        StreamInterface $streamInterface
    ) {
        $httpResponse->getBody()
            ->willReturn($streamInterface);

        $http->request(
            'POST',
            Argument::any(),
            Argument::any()
        )->willReturn($httpResponse);

        $this->beConstructedWith(
            $http,
            self::SHOPIFY_SHOP,
            self::SHOPIFY_API_TOKEN,
            self::SHOPIFY_API_VERSION
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function it_can_make_simple_request(
        ClientInterface $http,
        StreamInterface $streamInterface
    ) {
        $query = <<<QUERY
query {
  shop {
    name
    primaryDomain {
      url
      host
    }
  }
}
QUERY;
        $streamInterface->getContents()->willReturn($this->positiveResponseBody());

        $this->request($query);

        $data = [
            'query' => $query
        ];

        $body = JsonHandler::encode($data);

        $http->request(
            'POST',
            $this->uri(),
            [
                'headers' => [
                    'Content-Type'           => 'application/json',
                    'X-Shopify-Access-Token' => self::SHOPIFY_API_TOKEN
                ],
                'body' => $body
            ]
        )->shouldHaveBeenCalled();
    }

    function it_can_catch_api_response_errors(
        StreamInterface $streamInterface
    ) {
        $query = <<<QUERY
query {
  shop {
    name
    primaryDomainXXX {
      url
      host
    }
  }
}
QUERY;
        $streamInterface->getContents()->willReturn($this->errorResponseBody());

        $this->shouldThrow(ShopifyGraphQLErrorException::class)
            ->duringRequest($query);
    }

    private function uri()
    {
        return "https://" . self::SHOPIFY_SHOP . "/admin/api/" . self::SHOPIFY_API_VERSION . "/graphql.json";
    }

    private function positiveResponseBody()
    {
        return <<<QUERY
{
    "data": {
        "shop": {
            "name": "My Shop",
            "primaryDomain": {
                "url": "https:\\/\\/www.example.com",
                "host": "www.example.com"
            }
        }
    },
    "extensions": {
        "cost": {
            "requestedQueryCost": 2,
            "actualQueryCost": 2,
            "throttleStatus": {
                "maximumAvailable": 2000.0,
                "currentlyAvailable": 1998,
                "restoreRate": 100.0
            }
        }
    }
}

QUERY;
    }

    private function errorResponseBody()
    {
        return <<<BODY
{
    "errors": [
        {
            "message": "DAVE",
            "locations": [
                {
                    "line": 4,
                    "column": 5
                }
            ],
            "path": [
                "query",
                "shop",
                "primaryDomainXXX"
            ],
            "extensions": {
                "code": "undefinedField",
                "typeName": "Shop",
                "fieldName": "primaryDomainXXX"
            }
        }
    ]
}

BODY;

    }
}
