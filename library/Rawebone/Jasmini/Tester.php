<?php

namespace Rawebone\Jasmini;

/**
 * Core of the framework, provides the test running.
 */
class Tester
{
    protected $listener;
    protected $mocker;
    protected $currentDescription = "";

    public function __construct(ListenerInterface $listener, Mocker $mocker)
    {
        $this->listener = $listener;
        $this->mocker   = $mocker;
    }

    public function test($title, \Closure $test)
    {
        $status = TestStatus::PASSED;
        $ex     = null;

        try {
            $mocks = $this->mocker->mocks($test);
            call_user_func_array($test, $mocks);
        } catch (\Exception $ex) {
            $status = TestStatus::FAILED;
        }

        $this->notifyListener($title, $status, $ex);
    }

    public function pending($title, \Closure $test)
    {
        $this->notifyListener($title, TestStatus::PENDING);
    }

    protected function notifyListener($title, $status, \Exception $ex = null)
    {
        $this->listener->record($this->currentDescription, $title, $status);
    }

    public function describe($description, \Closure $tests)
    {
        $this->currentDescription = $description;
        $tests();
    }
}
