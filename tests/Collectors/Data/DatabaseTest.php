<?php
/**
 * User: LAHAXE Arnaud
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Test\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

class DatabaseTest extends \PHPUnit_Framework_TestCase
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

        $this->collector = new Database($this->process, $this->datasource);
    }


    public function testPersist()
    {

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}


class Database extends \Ndrx\Profiler\Collectors\Data\Database
{


    protected function registerListeners()
    {
        $this->data[] = array(
            'query' => 'SELECT foo FROM bar where id = ?',
            'bindQuery' => 'SELECT foo FROM bar where id = 1',
            'bindings' => ['id' => 1],
            'duration' => microtime(true),
            'connection' => 'mysql',
            'explain' => []
        );


        $this->stream();
    }

    /**
     * Write data in the datasource and clean current buffer
     * @return mixed
     */
    public function stream()
    {
        $patch = $this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, $this->data, true);
        $this->dataSource->save($this->process, [$patch]);
        $this->data = [];
    }
}