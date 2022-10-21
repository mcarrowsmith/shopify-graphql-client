<?php

use McArrowsmithPackages\ShopifyGraphQLClient\ClientFactory;

include __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$factory = ClientFactory::make(
    $_ENV['SHOPIFY_SHOP'],
    $_ENV['SHOPIFY_TOKEN']
);

$query = <<<QUERY
query {
  shop {
    name
  }
}
QUERY;

try {
    var_dump($factory->request($query));
} catch (\Throwable $t) {
    echo $t->getMessage() . PHP_EOL;
    die(1);
}
