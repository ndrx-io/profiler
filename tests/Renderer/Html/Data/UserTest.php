<?php

namespace Ndrx\Profiler\Test\Renderer\Html\Data;

use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\ProfilerFactory;
use Ndrx\Profiler\Renderer\Html\Data\User;


/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 07/12/2015
 * Time: 20:11
 */
class UserTest extends \PHPUnit_Framework_TestCase
{

    public function testNoData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new User([], $profiler);

        $this->assertFalse($renderer->getBarContent());
        $this->assertInternalType('array', $renderer->getData());
        $this->assertEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertEquals('-', $renderer->getBadge());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->content());
    }


    public function testData()
    {
        $profiler = ProfilerFactory::build([
            ProfilerFactory::OPTION_ENABLE => true,
            ProfilerFactory::OPTION_DATASOURCE_CLASS => File::class,
            ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp'
        ]);

        $renderer = new User([
            "value" => [
                'id' => 1,
                'identifier' => 'foo',
                'detail' => [
                    'foo' => 'bar'
                ]
            ]
        ], $profiler);

        $this->assertFalse($renderer->getBarContent());
        $this->assertInternalType('array', $renderer->getData());
        $this->assertNotEmpty($renderer->getData());
        $this->assertNotEmpty($renderer->getTitle());
        $this->assertEmpty($renderer->getBarContent());
        $this->assertEquals('foo', $renderer->getBadge());
        $this->assertNotEmpty($renderer->getIcon());
        $this->assertNotEmpty($renderer->content());
    }
}