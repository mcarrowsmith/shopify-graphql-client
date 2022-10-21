<?php

use McArrowsmithPackages\ShopifyGraphQLClient\ClientFactory;

include __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$factory = ClientFactory::make(
    $_ENV['SHOPIFY_SHOP'],
    $_ENV['SHOPIFY_TOKEN']
);

$count = 30;
$query = <<<'QUERY'
query ($numberOfProducts: Int!) {
  products(first: $numberOfProducts) {
    edges {
      node {
        id
        title
        handle
      }
    }
  }
}
QUERY;

$variables = [
    'numberOfProducts' => $count
];

try {
    var_dump($factory->request($query, $variables));
} catch (\Throwable $t) {
    echo $t->getMessage() . PHP_EOL;
    die(1);
}
