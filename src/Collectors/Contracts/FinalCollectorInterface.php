<?php

namespace Ndrx\Profiler\Collectors\Contracts;

/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 31/10/15
 * Time: 17:33
 */
interface FinalCollectorInterface extends CollectorInterface
{
    /**
     * Fetch data
     * @return void
     */
    public function resolve();
}
