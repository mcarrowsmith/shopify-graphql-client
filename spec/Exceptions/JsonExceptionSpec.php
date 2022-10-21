<?php

namespace spec\McArrowsmithPackages\ShopifyGraphQLClient\Exceptions;

use McArrowsmithPackages\ShopifyGraphQLClient\Exceptions\JsonException;
use PhpSpec\ObjectBehavior;

class JsonExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JsonException::class);
        $this->shouldBeAnInstanceOf(\Exception::class);
    }
}
