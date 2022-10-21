<?php

namespace spec\McArrowsmithPackages\ShopifyGraphQLClient;

use McArrowsmithPackages\ShopifyGraphQLClient\ClientFactory;
use PhpSpec\ObjectBehavior;

class ClientFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ClientFactory::class);
    }
}
