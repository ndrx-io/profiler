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
use Ndrx\Profiler\Collectors\Data\Context;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;

class ContextTest extends \PHPUnit_Framework_TestCase
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
        $this->process = Process::build();

        $this->collector = new Context($this->process, $this->datasource);
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