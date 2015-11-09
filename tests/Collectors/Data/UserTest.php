<?php
/**
 * User: LAHAXE Arnaud
 * Date: 04/11/2015
 * Time: 16:04
 * FileName : ContextTest.php
 * Project : profiler
 */

namespace Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\DataSources\Contracts\DataSourceInterface;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Process;

class UserTest extends \PHPUnit_Framework_TestCase
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

        $this->collector = new User($this->process, $this->datasource);
        $user = new \stdClass();
        $user->email = 'foo@bar.fr';
        $user->id = 1;
        $user->phone = '+33123456789';
        $this->collector->setUser($user);
    }

    public function testSetUser()
    {

        $this->collector->resolve();

        $data = $this->collector->getData();

        $this->assertInternalType('array', $data);
    }

    public function testResolve()
    {
        $this->collector->resolve();

        $data = $this->collector->getData();
        $this->assertInternalType('array', $data);
        $this->assertEquals(1, $this->collector->getUser()->id);
    }

    public function testPersist()
    {
        $this->collector->resolve();
        $this->collector->persist();

        $this->assertInstanceOf(\Generator::class, $this->datasource->getProcess($this->process->getId()));
    }
}


class User extends \Ndrx\Profiler\Collectors\Data\User {

    /**
     * Return the user user identifier email/username or whatever
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->user->email;
    }

    /**
     * Return the user id or uuid
     *
     * @return string|int
     */
    public function getId()
    {
        return $this->user->id;
    }

    /**
     * User details for examples roles, timestamps...
     *
     * @return array
     */
    public function getDetails()
    {
        return [
            'phone' => $this->user->phone
        ];
    }
}