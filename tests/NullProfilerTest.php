<?php

namespace Ndrx\Profiler\Test;

use Ndrx\Profiler\Context\NullContext;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\NullProfiler;
use Ndrx\Profiler\Context\Contracts\ContextInterface;

/**
 * Class ProfilerTest
 * @package Ndrx\Profiler\Test
 */
class NullProfilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NullProfiler
     */
    protected $profiler;

    protected function setUp()
    {
        parent::setUp();

        $this->profiler = new NullProfiler();
    }

    public function testContext()
    {
        $this->assertInstanceOf(ContextInterface::class, $this->profiler->getContext());
        $this->assertInstanceOf(NullContext::class, $this->profiler->getContext());
    }

}
