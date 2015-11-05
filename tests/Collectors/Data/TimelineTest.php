<?php
/**
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Data\Timeline;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;
use Ndrx\Profiler\Profiler;
use Ndrx\Profiler\Components\Timeline as TimelineComponent;

class TimelineTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DataSourceInterface
     */
    protected $datasource;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var Collector
     */
    protected $collector;

    /**
     * @var Profiler
     */
    protected $profiler;

    protected function setUp()
    {
        parent::setUp();

        $this->datasource = new Memory();
        $this->profiler = new Profiler();
        $dispatcher = $this->profiler->getContext()->getProcess()->getDispatcher();
        $this->profiler->setTimeline(new TimelineComponent($dispatcher));
        $this->profiler->setDataSource($this->datasource);
        $this->process   = $this->profiler->getContext()->getProcess();
        $this->collector = new Timeline($this->process, $this->profiler->getDatasource());

        $this->profiler->registerCollector($this->collector);

    }

    public function testResolve()
    {
        $this->profiler->start('foo', 'barbar');
        $this->profiler->stop('foo');
        $this->profiler->monitor('Foobar', function() {
            // yeah
        });

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}