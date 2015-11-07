<?php

namespace Ndrx\Profiler\Test;

use Ndrx\Profiler\Components\Logs\Monolog;
use Ndrx\Profiler\Components\Logs\Simple;
use Ndrx\Profiler\Context\Cli;
use Ndrx\Profiler\Context\Http;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\DataSources\NullDataSource;
use Ndrx\Profiler\NullProfiler;
use Ndrx\Profiler\Profiler;
use Ndrx\Profiler\ProfilerFactory;


/**
 * Class ProfilerTest
 * @package Ndrx\Profiler\Test
 */
class ProfilerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testEnable()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $this->assertInstanceOf(Profiler::class, $profiler);
        $this->assertInstanceOf(File::class, $profiler->getDatasource());
        $this->assertInstanceOf(Simple::class, $profiler->getLogger());
        $this->assertInstanceOf(Cli::class, $profiler->getContext());
        $this->assertEquals('/tmp', $profiler->getDatasource()->getFolder());
    }

    public function testNotEnable()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => false
        ]);

        $this->assertInstanceOf(NullProfiler::class, $profiler);
        $this->assertInstanceOf(NullDataSource::class, $profiler->getDatasource());
    }

    public function testMemoryDataSource()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_DATASOURCE_CLASS => Memory::class
        ]);

        $this->assertInstanceOf(Memory::class, $profiler->getDatasource());
    }

    public function testMonologLogger()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_LOGGER => Monolog::class
        ]);

        $this->assertInstanceOf(Monolog::class, $profiler->getLogger());
    }

    public function testHttpContext()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENVIRONMENT => 'http'
        ]);

        $this->assertInstanceOf(Profiler::class, $profiler);
        $this->assertInstanceOf(Http::class, $profiler->getContext());
    }
}
