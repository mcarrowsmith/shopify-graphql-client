<?php

namespace spec\McArrowsmithPackages\ShopifyGraphQLClient\Exceptions;

use McArrowsmithPackages\ShopifyGraphQLClient\Exceptions\ShopifyGraphQLErrorException;
use PhpSpec\ObjectBehavior;

class ShopifyGraphQLErrorExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShopifyGraphQLErrorException::class);
    }
}
