<?php
/**
 * User: LAHAXE Arnaud
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Test\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\JsonPatch;
use Ndrx\Profiler\Process;

class MailTest extends \PHPUnit_Framework_TestCase
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

    protected function setUp()
    {
        parent::setUp();

        $this->datasource = new Memory();
        $this->process = Process::build();

        $this->collector = new Mail($this->process, $this->datasource);
    }


    public function testPersist()
    {

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}


class Mail extends \Ndrx\Profiler\Collectors\Data\Mail
{


    protected function registerListeners()
    {
        $this->data [] = [
            'from' => 'from@email.com',
            'to' => ['to@email.com'],
            'bcc' => ['copy@email.com'],
            'cc' => ['copy2@email.com'],
            'subject' => 'Foooooo',
            'content' => 'BarBarFoo'
        ];


        $this->stream();
    }

    /**
     * Write data in the datasource and clean current buffer
     * @return mixed
     */
    public function stream()
    {
        $patch = $this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, $this->data, true);
        $this->dataSource->save($this->process, [$patch]);
        $this->data = [];
    }
}