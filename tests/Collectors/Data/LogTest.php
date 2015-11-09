<?php
/**
 * User: LAHAXE Arnaud
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Test\Collectors\Data;

use Monolog\Logger;
use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Data\Log;
use Ndrx\Profiler\Components\Logs\Monolog;
use Ndrx\Profiler\Components\Logs\Simple;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;
use Ndrx\Profiler\Profiler;

class LogTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DataSourceInterface
     */
    protected $datasource;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var Collector
     */
    protected $collector;

    /**
     * @var Profiler
     */
    protected $profiler;

    protected function setUp()
    {
        parent::setUp();

        $this->datasource = new Memory();
        $this->profiler = new Profiler();
        $this->profiler->setDataSource($this->datasource);
        $this->process = $this->profiler->getContext()->getProcess();
        $this->collector = new Log($this->process, $this->profiler->getDatasource());
        $this->profiler->registerCollector($this->collector);

    }

    public function testResolve()
    {
        $logger = new Simple();
        $logger->setDispatcher($this->process->getDispatcher());
        $this->profiler->setLogger($logger);
        $this->profiler->alert('FooBar');
        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }

    public function testResolveMonolog()
    {
        $monolog = new Monolog();

        $log = new Logger('name');
        $log->pushHandler($monolog);
        $monolog->setDispatcher($this->process->getDispatcher());
        $this->profiler->setLogger($monolog);

        $log->addError('Bar');

        $this->profiler->alert('FooBar');

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}