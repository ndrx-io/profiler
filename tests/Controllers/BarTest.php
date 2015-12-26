<?php

namespace Ndrx\Profiler\Test\Controllers;

use Ndrx\Profiler\Controllers\Bar;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;

class BarTest extends \PHPUnit_Framework_TestCase
{

    public function testShow()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $bar = new Bar($profiler);

        $result = $bar->show($profiler->getContext()->getProcess()->getId());
        $this->assertNotEmpty($result);
    }

    public function testShowNotFound()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $bar = new Bar($profiler);

        $result = $bar->show('FooBarr');
        $this->assertNotEmpty($result);
    }
}