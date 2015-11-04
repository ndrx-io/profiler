<?php
/**
 * Date: 04/11/2015
 * Time: 11:07
 * FileName : FileTest.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Test\DataSources;

use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;

class FileTest extends \PHPUnit_Framework_TestCase
{

    /** @var  DataSourceInterface */
    protected $datasource;

    protected function setUp()
    {
        parent::setUp();

        $folder = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'data' .DIRECTORY_SEPARATOR;
        if(!is_dir($folder)) {
            mkdir($folder);
        }

        $this->datasource = new File($folder);
        $this->datasource->clear();
    }

    public function testAll()
    {
        $profiles = $this->datasource->all();
        $this->assertEquals(0, count($profiles));
        $this->datasource->saveSummary(Process::build(), [
            'foo' => 'bar'
        ]);
        $this->datasource->saveSummary(Process::build(), [
            'foo' => 'bar'
        ]);
        $this->datasource->saveSummary(Process::build(), [
            'foo' => 'bar'
        ]);
        $this->assertEquals(3, $this->datasource->count());
        $profiles = $this->datasource->all(1);
        $this->assertEquals(2, count($profiles));
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
        $profiles = $this->datasource->all();
        $this->assertEquals(1, count($profiles));
        $profile = current($profiles);

        $this->assertObjectHasAttribute('foo', $profile);
        $this->assertEquals('bar', $profile->foo);
    }

}