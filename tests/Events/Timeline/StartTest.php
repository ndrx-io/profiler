<?php

namespace Ndrx\Profiler\Test\Events\Timeline;


use Ndrx\Profiler\Events\Timeline\Start;

class StartTest extends \PHPUnit_Framework_TestCase
{

    public function testToArray()
    {
        $timestamp = time();
        $start = new Start('foo', 'FooBar', [
            'foo' => 'bar'
        ], $timestamp);

        $array = $start->toArray();

        $this->assertEquals('foo', $array['key']);
        $this->assertEquals('foo', $start->getKey());

        $this->assertEquals('FooBar', $array['label']);
        $this->assertEquals('FooBar', $start->getLabel());

        $this->assertInternalType('array', $array['data']);
        $this->assertInternalType('array', $start->getData());
        $this->assertArrayHasKey('foo', $array['data']);
        $this->assertArrayHasKey('foo', $start->getData());
        $this->assertEquals('bar', $array['data']['foo']);
        $this->assertEquals('bar', $start->getData()['foo']);

        $this->assertEquals($timestamp, $array['timestamp']);
        $this->assertEquals($timestamp, $start->getTimestamp());
    }
}