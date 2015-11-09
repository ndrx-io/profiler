<?php
/**
 * Date: 04/11/2015
 * Time: 11:07
 * FileName : MemoryTest.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Test\DataSources;

use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\DataSources\NullDataSource;
use Ndrx\Profiler\Process;

class NullDataSourceTest extends \PHPUnit_Framework_TestCase
{

    /** @var  DataSourceInterface */
    protected $datasource;

    protected function setUp()
    {
        parent::setUp();

        $this->datasource = new NullDataSource();
    }

    public function testAll()
    {
        $profiles = $this->datasource->all();
        $this->assertEquals(0, count($profiles));
    }

    public function testCount()
    {
        $this->assertEquals(0, $this->datasource->count());
    }

    public function testGetProcess()
    {

        $profile = $this->datasource->getProcess('XXX');
        $this->assertInstanceOf(\Generator::class, $profile);
        $array = iterator_to_array($profile);
        $this->assertCount(1, $array);
    }

    public function testClear()
    {
        $this->datasource->clear();
        $this->assertEquals(0, $this->datasource->count());
    }

    public function testDeleteProcess()
    {
        $this->datasource->deleteProcess('XXXX');
        $this->assertEquals(0, $this->datasource->count());
    }

    public function testSave()
    {
        $process = Process::build();
        $this->datasource->save($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(0, $this->datasource->count());
    }

    public function testSaveSummary()
    {
        $process = Process::build();
        $this->datasource->saveSummary($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(0, $this->datasource->count());
    }

}