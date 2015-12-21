<?php

namespace Ndrx\Profiler\Test\Renderer\Html\Data;

use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;
use Ndrx\Profiler\Renderer\Html\Data\CpuUsage;


/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 07/12/2015
 * Time: 20:11
 */
class CpuUsageTest extends \PHPUnit_Framework_TestCase
{

    public function testNoData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new CpuUsage([], $profiler);

        $this->assertFalse($renderer->getBarContent());
        $this->assertInternalType('array', $renderer->getData());
        $this->assertEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertEquals('-', $renderer->getBadge());
        $this->assertNotEmpty($renderer->getIcon());
    }


    public function testData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new CpuUsage([
            "value" => 1000,
        ], $profiler);

        $this->assertFalse($renderer->getBarContent());
        $this->assertInternalType('array', $renderer->getData());
        $this->assertNotEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertEquals('1ms', $renderer->getBadge());
        $this->assertNotEmpty($renderer->getIcon());
    }
}