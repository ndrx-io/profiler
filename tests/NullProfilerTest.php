<?php

namespace Ndrx\Profiler\Test;

use Ndrx\Profiler\Collectors\Data\Context;
use Ndrx\Profiler\Collectors\Data\PhpVersion;
use Ndrx\Profiler\Components\Logs\Simple;
use Ndrx\Profiler\Components\Timeline;
use Ndrx\Profiler\Context\NullContext;
use Ndrx\Profiler\DataSources\NullDataSource;
use Ndrx\Profiler\NullProfiler;
use Ndrx\Profiler\Context\Contracts\ContextInterface;
use Ndrx\Profiler\Process;

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
        $this->profiler->getContext()->initiate();
        $this->profiler->getContext()->sendDebugIds();
        $this->assertInstanceOf(ContextInterface::class, $this->profiler->getContext());
        $this->assertInstanceOf(NullContext::class, $this->profiler->getContext());
    }

    public function testSetters()
    {
        $this->profiler->setLogger(new Simple());
        $this->profiler->setDataSource(new NullDataSource());
        $this->profiler->setTimeline(new Timeline(Process::build()->getDispatcher()));

    }

    public function testDetectEnv()
    {
        $this->assertEquals('null', $this->profiler->detectEnv());
    }

    public function testDestroy()
    {
        $this->profiler->destroy();
    }

    public function testRegisterCollector()
    {
        $this->profiler->registerCollector(new PhpVersion(Process::build(), new NullDataSource()));
        $this->profiler->initiate();
        $this->profiler->terminate();
    }

    public function testRegisterCollectors()
    {
        $this->profiler->registerCollectors([
            new PhpVersion(Process::build(), new NullDataSource()),
            new Context(Process::build(), new NullDataSource())
        ]);
        $this->profiler->initiate();
        $this->profiler->terminate();
    }

    public function testRegisterCollectorClass()
    {
        $this->profiler->registerCollectorClass(PhpVersion::class);
        $this->profiler->initiate();
        $this->profiler->terminate();
    }


    public function testRegisterCollectorClasses()
    {
        $this->profiler->registerCollectorClasses([
            PhpVersion::class
        ]);
        $this->profiler->initiate();
        $this->profiler->terminate();
    }

    public function testRunGroup()
    {
        $this->profiler->runGroup('foo');
    }

    public function testGetProfile()
    {
        $profile = $this->profiler->getProfile('foo');
        $this->assertInstanceOf(\stdClass::class, $profile);
    }

    public function testGetLogger()
    {
        $this->assertInstanceOf(Simple::class, $this->profiler->getLogger());
    }

    public function testMagicCall()
    {
        $this->profiler->start('foo', 'BAR');
        $this->profiler->stop('foo');
        $this->profiler->error('No beer');
    }
}
