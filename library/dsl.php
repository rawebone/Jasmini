<?php

use Rawebone\Jasmini\DSLAccessor;
use Esperance\Assertion;

function describe($description, \Closure $fn)
{
    DSLAccessor::describe($description, $fn);
}

function it($title, \Closure $fn)
{
    DSLAccessor::test($title, $fn);
}

function xit($title, \Closure $fn)
{
    DSLAccessor::pending($title, $fn);
}

/**
 * Returns an expectation.
 *
 * @param $condition
 * @return \Esperance\Assertion
 */
function expect($condition)
{
    return new Assertion($condition);
}
