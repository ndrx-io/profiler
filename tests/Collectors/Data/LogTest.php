<?php
/**
 * User: LAHAXE Arnaud
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Data\Log;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Events\Log as LogEvent;
use Ndrx\Profiler\Process;
use Ndrx\Profiler\Profiler;

class LogTest extends \PHPUnit_Framework_TestCase
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
        $this->profiler   = Profiler::getInstance();
        $this->profiler->setDataSource($this->datasource);
        $this->process   = $this->profiler->getContext()->getProcess();
        $this->collector = new Log($this->process, $this->profiler->getDatasource());

        $this->profiler->registerCollector($this->collector);

    }

    public function testResolve()
    {
        $this->process->getDispatcher()->dispatch(\Ndrx\Profiler\Events\Log::EVENT_NAME, new LogEvent(LOG_EMERG, 'No more beer', []));

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}