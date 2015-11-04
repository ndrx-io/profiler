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
use Ndrx\Profiler\Process;

class MemoryTest extends \PHPUnit_Framework_TestCase
{

    /** @var  DataSourceInterface */
    protected $datasource;

    protected function setUp()
    {
        parent::setUp();

        $this->datasource = new Memory();
    }

    public function testAll()
    {
        $profiles = $this->datasource->all();
        $this->assertEquals(0, count($profiles));
        $process = Process::build();
        $this->datasource->saveSummary($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
        $profiles = $this->datasource->all();
        $this->assertEquals(1, count($profiles));
    }

    public function testCount()
    {
        $this->assertEquals(0, $this->datasource->count());
        $this->datasource->save(Process::build(), [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
    }

    public function testGetProcess()
    {
        $process = Process::build();
        $this->datasource->save($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
        $profile = $this->datasource->getProcess($process->getId());
        $this->assertInstanceOf(\Generator::class, $profile);
    }

    public function testClear()
    {
        $this->datasource->save(Process::build(), [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
        $this->datasource->clear();
        $this->assertEquals(0, $this->datasource->count());
    }

    public function testDeleteProcess()
    {
        $process = Process::build();
        $this->datasource->save($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
        $this->datasource->deleteProcess($process->getId());
        $this->assertEquals(0, $this->datasource->count());
    }

    public function testSave()
    {
        $process = Process::build();
        $this->datasource->save($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
        $profile = $this->datasource->getProcess($process->getId());
        $this->assertInstanceOf(\Generator::class, $profile);
        $profile = json_decode(current(iterator_to_array($profile)));
        $this->assertInstanceOf(\stdClass::class, $profile);
        $this->assertObjectHasAttribute('foo', $profile);
        $this->assertEquals('bar', $profile->foo);
    }

    public function testSaveSummary()
    {
        $process = Process::build();
        $this->datasource->saveSummary($process, [
            'foo' => 'bar'
        ]);
        $this->assertEquals(1, $this->datasource->count());
        $profiles = $this->datasource->all();
        $this->assertEquals(1, count($profiles));
        $profile = current($profiles);

        $this->assertObjectHasAttribute('foo', $profile);
        $this->assertEquals('bar', $profile->foo);
    }

}