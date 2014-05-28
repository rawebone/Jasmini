<?php

namespace Rawebone\Jasmini;

class DSLAccessor
{
    protected static $inst;

    public static function init(Tester $tester)
    {
        self::$inst = $tester;
    }

    public static function __callStatic($name, $args)
    {
        return call_user_func_array(array(self::$inst, $name), $args);
    }
}
