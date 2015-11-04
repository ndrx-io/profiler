<?php

namespace Ndrx\Profiler\Test\Events\Timeline;

use Ndrx\Profiler\Events\Timeline\End;

class EndTest extends \PHPUnit_Framework_TestCase
{

    public function testToArray()
    {
        $timestamp = time();
        $end       = new End('foo', $timestamp);

        $array = $end->toArray();

        $this->assertEquals('foo', $array['key']);
        $this->assertEquals('foo', $end->getKey());

        $this->assertEquals($timestamp, $array['timestamp']);
        $this->assertEquals($timestamp, $end->getTimestamp());
    }
}
