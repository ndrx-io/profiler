<?php

namespace Ndrx\Profiler\Test\Renderer\Html\Data;

use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;
use Ndrx\Profiler\Renderer\Html\Data\Route;


/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 07/12/2015
 * Time: 20:11
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{

    public function testNoData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new Route([], $profiler);

        $this->assertInternalType('array', $renderer->getData());
        $this->assertEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertEquals('tab/route.html.twig', $renderer->getTemplate());
        $this->assertNotEmpty($renderer->content());
    }


    public function testData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new Route([
            "value" => [
                [
                    'method' => 'GET',
                    'uri' => '/foo',
                    'name' => 'foo',
                    'action' => 'foo.do',
                    'middleware' => null
                ]
            ],
        ], $profiler);

        $this->assertInternalType('array', $renderer->getData());
        $this->assertNotEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->content());
    }
}