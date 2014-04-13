<?php

namespace spec\Rawebone\Jasmini;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Rawebone\Jasmini\ListenerInterface;
use Rawebone\Jasmini\Mocker;
use Rawebone\Jasmini\TestStatus;

class TesterSpec extends ObjectBehavior
{
    function let(ListenerInterface $listener, Mocker $mocker)
    {
        $this->beConstructedWith($listener, $mocker);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Rawebone\Jasmini\Tester');
    }

    function it_should_record_a_test(ListenerInterface $listener, Mocker $mocker)
    {
        $mocker->mocks(Argument::type("Closure"))
               ->willReturn(array())
               ->shouldBeCalled();

        $listener->record("", "a test", TestStatus::PASSED, null)
                 ->shouldBeCalled();

        $this->test("a test", function () {});
    }

    function it_should_record_a_failing_test(ListenerInterface $listener, Mocker $mocker)
    {
        $mocker->mocks(Argument::type("Closure"))
            ->willReturn(array())
            ->shouldBeCalled();

        $listener->record("", "a test", TestStatus::FAILED, null)
                 ->shouldBeCalled();

        $this->test("a test", function () { throw new \Exception(); });
    }

    function it_should_record_a_pending_test(ListenerInterface $listener)
    {
        $listener->record("", "a test", TestStatus::PENDING);

        $this->pending("a test", function () {});
    }

    function it_should_describe_a_test(ListenerInterface $listener)
    {
        $listener->record("my tests", "a test", TestStatus::PENDING);

        $self = $this;
        $this->describe("my tests", function () use ($self)
        {
            $self->pending("a test", function () {});
        });
    }
}
