<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 04/11/15
 * Time: 20:13
 */

namespace Ndrx\Profiler\Components\Logs;


use Ndrx\Profiler\Events\DispatcherAwareInterface;
use Ndrx\Profiler\Events\DispatcherAwareTrait;
use Ndrx\Profiler\Events\Log;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Simple extends AbstractLogger implements DispatcherAwareInterface, LoggerInterface
{

    use DispatcherAwareTrait;

    /**
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->dispatcher = $eventDispatcher;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $this->dispatcher->dispatch(Log::EVENT_NAME, new Log($level, $message, $context, []));
    }
}
