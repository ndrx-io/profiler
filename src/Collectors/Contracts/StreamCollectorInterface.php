<?php

namespace Ndrx\Profiler\Collectors\Contracts;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 17:33
 */
interface StreamCollectorInterface extends CollectorInterface
{
    /**
     * Write data in the datasource and clean current buffer
     * @return mixed
     */
    public function stream();
}
