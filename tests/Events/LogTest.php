<?php

namespace Ndrx\Profiler\Test\Events;


use Ndrx\Profiler\Events\Log;

class LogTest extends \PHPUnit_Framework_TestCase
{

    public function testToArray()
    {
        $log = new Log(LOG_ALERT, 'No more beer', [
            'foo' => 'bar',
        ]);

        $array = $log->toArray();

        $this->assertEquals(LOG_ALERT, $array['level']);
        $this->assertEquals(LOG_ALERT, $log->getLevel());

        $this->assertEquals('No more beer', $array['message']);
        $this->assertEquals('No more beer', $log->getMessage());

        $this->assertInternalType('array', $array['context']);
        $this->assertInternalType('array', $log->getContext());
        $this->assertArrayHasKey('foo', $array['context']);
        $this->assertArrayHasKey('foo', $log->getContext());
        $this->assertEquals('bar', $array['context']['foo']);
        $this->assertEquals('bar', $log->getContext()['foo']);

        $this->assertInternalType('array', $array['stack']);
        $this->assertInternalType('array', $log->getStack());
    }
}