[<img src="https://mcarrowsmith.co.uk/assets/images/mcarrowsmith-consulting-social-card.png" />](https://mcarrowsmith.co.uk)

# Shopify GraphQL Client

PHP Client to send GraphQL requests to Shopify Admin API.

## Installation

You can install the package via composer:

```bash
composer require mcarrowsmith-packages/shopify-graphql-client
```

## Usage

Make sure you have correct credentials to access the Shopify Store via Partner Account or Custom App.

```php
use \McArrowsmithPackages\ShopifyGraphQLClient\ClientFactory;

$query = <<<'QUERY'
query {
  shop {
    name
  }
}
QUERY;

$factory = ClientFactory::make('example.myshopify.com', '<API-TOKEN>', '2022-07');

try {
    $factory->request($query);
} catch (\Throwable $t) {
    echo $t->getMessage() . PHP_EOL;
}
```

See [scripts](scripts) for full usage and examples.

## Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/mcarrowsmith/.github/blob/main/CONTRIBUTING.md) for details.
