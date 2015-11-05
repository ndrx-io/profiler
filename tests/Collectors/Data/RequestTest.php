<?php
/**
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Data\Request;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;
use Ndrx\Profiler\Profiler;

class RequestTest extends \PHPUnit_Framework_TestCase
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

    protected function setUp()
    {
        parent::setUp();

        $this->datasource = new Memory();
        $profiler = new Profiler();
        $profiler->setDataSource($this->datasource);
        $this->process   = $profiler->getContext()->getProcess();
        $this->collector = new Request($this->process, $profiler->getDatasource());

        $profiler->registerCollector($this->collector);

    }

    public function testResolve()
    {
        $this->collector->resolve();

        $data = $this->collector->getData();

        $this->assertInternalType('array', $data);
    }

    public function testPersist()
    {
        $this->collector->resolve();
        $this->collector->persist();

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}