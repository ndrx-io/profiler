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
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;

class RouteTest extends \PHPUnit_Framework_TestCase
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

        $this->collector = new Route($this->process, $this->datasource);
    }

    public function testSetUser()
    {

        $this->collector->resolve();

        $data = $this->collector->getData();

        $this->assertInternalType('array', $data);
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


class Route extends \Ndrx\Profiler\Collectors\Data\Route
{

    /**
     * Fetch data
     * @return void
     */
    public function resolve()
    {
        $this->data = [
            [
                'uri' => '/foo/{bar}',
                'name' => 'foo',
                'acl' => ['foo', 'bar'],
                'middleware' => ['admin', 'cors']
            ]
        ];
    }
}