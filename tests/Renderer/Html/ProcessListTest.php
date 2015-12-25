<?php

namespace Ndrx\Profiler\Test\Renderer\Html;

use Ndrx\Profiler\Collectors\Data\PhpVersion;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;
use Ndrx\Profiler\Renderer\Html\Process;
use Ndrx\Profiler\Renderer\Html\ProcessList;

class ProfileListTest extends \PHPUnit_Framework_TestCase
{


    public function testData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp',
            ProfilerFactory::OPTION_COLLECTORS => [
                PhpVersion::class,
            ]
        ]);
        $profiler->initiate();
        $profiler->terminate();

        $profiles = $profiler->getDatasource()->all(0, 10);

        $renderer = new ProcessList($profiles);

        $this->assertInternalType('array', $renderer->getData());
        $this->assertNotEmpty($renderer->getData());
        $this->assertArrayHasKey('profiles', $renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->content());
    }

}