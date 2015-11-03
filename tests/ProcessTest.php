<?php

namespace Ndrx\Profiler\Test;

use Ndrx\Profiler\Process;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 03/11/15
 * Time: 22:08
 */
class ProcessTest extends \PHPUnit_Framework_TestCase
{

    public function testBuild()
    {
        $process = Process::build();
        $this->assertInstanceOf(Process::class, $process);
        $this->assertNotNull($process->getId());
        $this->assertInstanceOf(EventDispatcher::class, $process->getDispatcher());

    }

    public function testBuildWithParentId()
    {
        $process = Process::build('foo');
        $this->assertInstanceOf(Process::class, $process);
        $this->assertNotNull($process->getId());
        $this->assertEquals('foo', $process->getParentId());
        $this->assertInstanceOf(EventDispatcher::class, $process->getDispatcher());
    }


}