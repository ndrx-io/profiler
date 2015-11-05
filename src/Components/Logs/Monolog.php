<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 04/11/15
 * Time: 20:13
 */

namespace Ndrx\Profiler\Components\Logs;

use Monolog\Handler\AbstractProcessingHandler;
use Ndrx\Profiler\Events\DispatcherAwareInterface;
use Ndrx\Profiler\Events\DispatcherAwareTrait;
use Ndrx\Profiler\Events\Log;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Monolog extends AbstractProcessingHandler implements DispatcherAwareInterface, LoggerInterface
{
    use DispatcherAwareTrait, LoggerTrait;

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

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        $this->log($record['level'], $record['message']);
    }
}
