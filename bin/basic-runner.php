<?php

if (!class_exists('Composer\Autoload\ClassLoader.php')) {
    require_once(__DIR__ . "/../vendor/autoload.php");
}

require_once(__DIR__ . "/../library/dsl.php");

$testDir = getcwd() . "/tests/";
if (!is_dir($testDir)) {
    output("Could not find directory '$testDir'");
    exit(1);
}

use Rawebone\Jasmini\DSLAccessor;
use Rawebone\Jasmini\Tester;
use Rawebone\Jasmini\Mocker;
use Rawebone\Jasmini\Output\BasicHtml;
use Rawebone\Injector\SignatureReader;
use Prophecy\Prophet;

$listener = new BasicHtml(dirname($testDir) . "/test-results.html");
$mocker   = new Mocker(new Prophet(), new SignatureReader());

DSLAccessor::init(new Tester($listener, $mocker));

set_error_handler(function ($level, $message, $file = 'unknown', $line = 0, $context = array())
{
    $regex = '/^Argument (\d)+ passed to \{closure\}\(\) must (?:be an instance of|implement interface) ([\w\\\]+),(?: instance of)? ([\w\\\]+) given/';

    if (E_RECOVERABLE_ERROR === $level && preg_match($regex, $message, $matches)) {
        list($_, $_, $shouldBe, $type) = $matches;

        if ($type === "Prophecy\\Prophecy\\ObjectProphecy") {
            return true;
        }
    }

    return false;
});

output("Jasmini");
output("=======");
output("");

foreach (new DirectoryIterator($testDir) as $test) {
    if (in_array($test, array(".", ".."))) {
        continue;
    }

    output("Testing: $test");
    \Composer\Autoload\includeFile($test->getRealPath());
}

$listener->stop();

output("");
output("Finished");
output("");

function output($msg)
{
    echo $msg, PHP_EOL;
}
