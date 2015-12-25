<?php

namespace Ndrx\Profiler\Test\Renderer\Html;

use Ndrx\Profiler\Collectors\Data\PhpVersion;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;
use Ndrx\Profiler\Renderer\Html\Bar;
use Ndrx\Profiler\Renderer\Html\BarLoader;

class BarLoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new BarLoader([], $profiler);

        $this->assertInternalType('array', $renderer->getData());
        $this->assertNotEmpty($renderer->getData());
        $this->assertArrayHasKey('processId', $renderer->getData());
        $this->assertEquals($profiler->getContext()->getProcess()->getId(), $renderer->getData()['processId']);
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertNotEmpty($renderer->content());
    }
}