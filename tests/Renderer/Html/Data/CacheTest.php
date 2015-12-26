<?php

namespace Ndrx\Profiler\Test\Renderer\Html\Data;

use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;
use Ndrx\Profiler\Renderer\Html\Data\Cache;


/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 07/12/2015
 * Time: 20:11
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{

    public function testNoData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new Cache([], $profiler);

        $this->assertFalse($renderer->getBarContent());
        $this->assertInternalType('array', $renderer->getData());
        $this->assertEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertEquals('-', $renderer->getBadge());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertNotEmpty($renderer->content());
    }


    public function testData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new Cache([
            "value" => [
                [
                    'action' => 'GET',
                    'value' => 'XXX',
                    'lifetime' => 100,
                    'key' => 'bwa',
                    'result' => 'XXX',
                    'success' => true,
                ]
            ]
        ], $profiler);

        $this->assertFalse($renderer->getBarContent());
        $this->assertInternalType('array', $renderer->getData());
        $this->assertNotEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertEquals('Cache (1)', $renderer->getBadge());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->content());
    }


    public function testSetData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new Cache([], $profiler);

        $renderer->setData([
            "value" => [
                [
                    'action' => 'GET',
                    'value' => 'XXX',
                    'lifetime' => 100,
                    'key' => 'bwa',
                    'result' => 'XXX',
                    'success' => true,
                ]
            ]
        ]);

        $this->assertEquals('GET', $renderer->getData()['value'][0]['action']);
        $this->assertEquals('XXX', $renderer->getData()['value'][0]['value']);
    }
}