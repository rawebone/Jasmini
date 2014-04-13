<?php

namespace Rawebone\Jasmini;

use Prophecy\Prophet;
use Rawebone\Injector\Func;
use Rawebone\Injector\SignatureReader;

class Mocker
{
    protected $prophet;
    protected $reader;

    public function __construct(Prophet $prophet, SignatureReader $reader)
    {
        $this->prophet = $prophet;
        $this->reader  = $reader;
    }

    public function mocks(\Closure $func)
    {
        $parameters = $this->reader->read(new Func($func));
        $mocks = array();

        foreach ($parameters as $parameter) {

            $type = $parameter["type"];
            if ($type === "array") {
                $type = "";
            }

            $mocks[$parameter["name"]] = $this->prophet->prophesize($type);
        }

        return $mocks;
    }
}
