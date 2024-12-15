<?php

namespace McArrowsmithPackages\ShopifyGraphQLClient;

interface ClientContract
{
    /** @return mixed */
    public function request(string $query, array $variables = []);
}
