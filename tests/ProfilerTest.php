<?php

namespace Ndrx\Profiler\Test;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Data\Duration;
use Ndrx\Profiler\Collectors\Data\PhpVersion;
use Ndrx\Profiler\Collectors\Data\Request;
use Ndrx\Profiler\Collectors\Data\Timeline;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Profiler;
use Ndrx\Profiler\Context\Contracts\ContextInterface;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 03/11/15
 * Time: 22:08
 */
class ProfilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Profiler
     */
    protected $profiler;

    protected function setUp()
    {
        parent::setUp();

        $this->profiler = Profiler::getInstance();
        $this->profiler->setCollectors([
            'initial' => [],
            'final' => [],
            'stream' => []
        ]);
        $this->profiler->setDataSource(new Memory());
    }

    public function testContext()
    {
        $this->assertInstanceOf(ContextInterface::class, $this->profiler->getContext());
    }

    public function testAddCollectorClass()
    {
        $this->profiler->registerCollector(new PhpVersion($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()));
        $this->profiler->registerCollector(new Timeline($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()));
        $this->profiler->registerCollector(new Duration($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()));

        $collectors = $this->profiler->getCollectors();

        $this->assertEquals(1, count($collectors['initial']));
        $this->assertEquals(1, count($collectors['final']));
        $this->assertEquals(1, count($collectors['stream']));
    }

    public function testAddCollectorsClass()
    {
        $this->profiler->registerCollectors([
            new PhpVersion($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()),
            new Request($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()),
            new Timeline($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()),
            new Duration($this->profiler->getContext()->getProcess(), $this->profiler->getDatasource()),
        ]);
        $collectors = $this->profiler->getCollectors();

        $this->assertEquals(2, count($collectors['initial']));
        $this->assertEquals(1, count($collectors['final']));
        $this->assertEquals(1, count($collectors['stream']));
    }

    public function testAddCollector()
    {
        $this->profiler->registerCollectorClass(PhpVersion::class);
        $this->profiler->registerCollectorClass(Timeline::class);
        $this->profiler->registerCollectorClass(Duration::class);

        $collectors = $this->profiler->getCollectors();

        $this->assertEquals(1, count($collectors['initial']));
        $this->assertEquals(1, count($collectors['final']));
        $this->assertEquals(1, count($collectors['stream']));
    }

    public function testAddCollectors()
    {
        $this->profiler->registerCollectorClasses([
            PhpVersion::class,
            Timeline::class,
            Duration::class
        ]);

        $collectors = $this->profiler->getCollectors();

        $this->assertEquals(1, count($collectors['initial']));
        $this->assertEquals(1, count($collectors['final']));
        $this->assertEquals(1, count($collectors['stream']));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAddCollectorError()
    {
        $this->profiler->registerCollectorClass(UnValidCollector::class);

    }

    public function testInitiate()
    {
        $this->profiler->registerCollectorClasses([
            PhpVersion::class,
            Timeline::class,
            Duration::class
        ]);
        $this->profiler->initiate();

        $process = $this->profiler->getContext()->getProcess();
        $this->assertInstanceOf(\Generator::class, $this->profiler->getDatasource()->getProcess($process->getId()));

        $profile = $this->profiler->getProfile($process->getId());
        $this->assertInstanceOf(\stdClass::class, $profile);
        $this->assertObjectHasAttribute('timeline', $profile);
        $this->assertObjectHasAttribute('php-version', $profile);
    }

    public function testTerminate()
    {
        $this->profiler->registerCollectorClasses([
            Duration::class
        ]);
        $this->profiler->initiate();
        $this->profiler->terminate();

        $process = $this->profiler->getContext()->getProcess();
        $this->assertInstanceOf(\Generator::class, $this->profiler->getDatasource()->getProcess($process->getId()));

        $profile = $this->profiler->getProfile($process->getId());
        $this->assertObjectHasAttribute('duration', $profile);
    }
}

class UnValidCollector extends Collector
{

    public function resolve()
    {
    }

    public function getPath()
    {
    }
}
