<?php

namespace Ndrx\Profiler\Test;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Data\Duration;
use Ndrx\Profiler\Collectors\Data\PhpVersion;
use Ndrx\Profiler\Collectors\Data\Request;
use Ndrx\Profiler\Collectors\Data\Timeline;
use Ndrx\Profiler\Context\Cli;
use Ndrx\Profiler\Context\Http;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Profiler;
use Ndrx\Profiler\Context\Contracts\ContextInterface;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 03/11/15
 * Time: 22:08
 */
class ProfilerHttpTest extends \PHPUnit_Framework_TestCase
{

    public function testContext()
    {
        Profiler::$environment = 'http';
        Profiler::destroy();
        $this->profiler = Profiler::getInstance();
        $this->assertInstanceOf(ContextInterface::class, $this->profiler->getContext());
        $this->assertInstanceOf(Http::class, $this->profiler->getContext());
    }

}