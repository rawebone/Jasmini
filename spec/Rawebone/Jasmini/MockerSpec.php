<?php

namespace spec\Rawebone\Jasmini;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Prophecy\Prophet;
use Rawebone\Injector\SignatureReader;
use Rawebone\Jasmini\TestStatus;

class MockerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Prophet(), new SignatureReader());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rawebone\Jasmini\Mocker');
    }

    function it_should_return_an_empty_array()
    {
        $this->mocks(function () {})->shouldReturn(array());
    }

    function it_should_return_mocks()
    {
        $func = function (TestStatus $status, $abc) { };

        $mocks = $this->mocks($func);
        $mocks["status"]->shouldBeAnInstanceOf('Prophecy\Prophecy\ObjectProphecy');
        $mocks["abc"]->shouldBeAnInstanceOf('Prophecy\Prophecy\ObjectProphecy');

        $mocks["status"]->reveal()->shouldBeAnInstanceOf('Rawebone\Jasmini\TestStatus');
    }
}
