<?php

namespace Ndrx\Profiler\Test\Controllers;

use Ndrx\Profiler\Controllers\Bar;
use Ndrx\Profiler\Controllers\Web;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;

class WebTest extends \PHPUnit_Framework_TestCase
{

    public function testIndex()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $web = new Web($profiler);

        $result = $web->index();
        $this->assertNotEmpty($result);

        $result = $web->index(0, 10);
        $this->assertNotEmpty($result);

        $result = $web->index(-1, 10);
        $this->assertNotEmpty($result);

        $result = $web->index(0, -1);
        $this->assertNotEmpty($result);
    }


    public function testShow()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $web = new Web($profiler);

        $result = $web->show($profiler->getContext()->getProcess()->getId());
        $this->assertNotEmpty($result);
    }

    public function testShowNotFound()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $web = new Web($profiler);

        $result = $web->show('FooBarr');
        $this->assertNotEmpty($result);
    }
}