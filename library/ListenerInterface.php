<?php

namespace Rawebone\Jasmini;

/**
 * Defines a listener for the test results - the listener can then write out
 * results to console/file or perform analysis etc.
 */
interface ListenerInterface
{
    /**
     * Signals that the testing has started.
     *
     * @return void
     */
    function start();

    /**
     * Signals that the testing has completed.
     *
     * @return void
     */
    function stop();

    /**
     * Signals that a test has been run.
     *
     * @param string $description
     * @param string $title
     * @param \Rawebone\Jasmini\TestStatus $status A TestStatus constant
     * @param \Exception $ex If applicable, the exception recorded to enable feedback to the user
     * @return void
     */
    function record($description, $title, $status, \Exception $ex = null);
}
