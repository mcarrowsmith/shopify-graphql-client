<?php

namespace McArrowsmithPackages\ShopifyGraphQLClient;

use GuzzleHttp\ClientInterface;
use McArrowsmithPackages\ShopifyGraphQLClient\Exceptions\ShopifyGraphQLErrorException;

class Client
{
    private ClientInterface $http;
    private string $shop;
    private string $token;
    private string $apiVersion;

    public function __construct(
        ClientInterface $http,
        string $shop,
        string $token,
        string $apiVersion,
    ) {
        $this->http       = $http;
        $this->shop       = $shop;
        $this->token      = $token;
        $this->apiVersion = $apiVersion;
    }

    /**
     * @param string $query
     * @param array  $variables
     *
     * @return mixed
     * @throws Exceptions\JsonException
     * @throws Exceptions\ShopifyGraphQLErrorException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $query, array $variables = [])
    {
        $data = ['query' => $query];

        if ($variables) {
            $data['variables'] = $variables;
        }

        $response = $this->makeRequest(
            JsonHandler::encode($data)
        );

        $responseData = JsonHandler::decode(
            $response->getBody()->getContents(),
            true
        );

        if (array_key_exists('errors', $responseData)) {
            throw ShopifyGraphQLErrorException::fromErrorData($responseData['errors']);
        }

        return $responseData;
    }

    /**
     * @param string $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest(string $body)
    {
        return $this->http
            ->request(
                'POST',
                $this->uri(),
                [
                    'headers' => [
                        'Content-Type'           => 'application/json',
                        'X-Shopify-Access-Token' => $this->token
                    ],
                    'body' => $body
                ]
            );
    }

    private function uri(): string
    {
        return "https://{$this->shop}/admin/api/{$this->apiVersion}/graphql.json";
    }
}
