<?php

namespace Rawebone\Jasmini\Output;

use Rawebone\Jasmini\ListenerInterface;
use Rawebone\Jasmini\TestStatus;

class BasicHtml implements ListenerInterface
{
    protected $recorded;
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
        $this->recorded = array();
    }

    /**
     * Signals that the testing has started.
     *
     * @return void
     */
    public function start()
    {
        $this->recorded = array();
    }

    /**
     * Signals that the testing has completed.
     *
     * @return void
     */
    public function stop()
    {
        $func = function (array $recorded, $file) {
            include $file;
        };

        ob_start();
        $func($this->recorded, __DIR__ . "/BasicHtmlTemplate.php");

        file_put_contents($this->file, ob_get_clean());
    }

    /**
     * Signals that a test has been run.
     *
     * @param string $description
     * @param string $title
     * @param \Rawebone\Jasmini\TestStatus $status A TestStatus constant
     * @param \Exception $ex If applicable, the exception recorded to enable feedback to the user
     * @return void
     */
    public function record($description, $title, $status, \Exception $exception = null)
    {
        if (!isset($this->recorded[$description])) {
            $this->recorded[$description] = array();
        }

        $this->recorded[$description][] = compact("title", "status", "exception");
    }
}
