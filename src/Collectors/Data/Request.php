<?php
/**
 * User: LAHAXE Arnaud
 * Date: 02/11/2015
 * Time: 14:07
 * FileName : Request.php
 * Project : profiler
 */

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;

class Request extends Collector implements StartCollectorInterface
{
    /**
     * Fetch data
     *
     * @return mixed
     */
    public function resolve()
    {
        $request = $this->process->getContext()->getRequest();
        $hasSession = $request->getSession() !== null;
        $this->data = [
            'method' => $request->getMethod(),
            'real-method' => $request->getRealMethod(),
            'uri' => $request->getUri(),
            'scriptName' => $request->getScriptName(),
            'port' => $request->getPort(),
            'ssl' => $request->isSecure(),
            'scheme' => $request->getScheme(),
            'accept-content-types' => $request->getAcceptableContentTypes(),
            'cookies' => $request->cookies->all(),
            'headers' => $request->headers->all(),
            'data' => [
                'get' => $request->query->all(),
                'post' => $request->request->all()
            ],
            'charsets' => $request->getCharsets(),
            'default-local' => $request->getDefaultLocale(),
            'local' => $request->getLocale(),
            'encodings' => $request->getEncodings(),
            'etags' => $request->getETags(),
            'session' => [
                'id' => $hasSession ? $request->getSession()->getId() : null,
                'data' => $hasSession ? $request->getSession()->all() : []
            ]
        ];
    }

    /**
     * The path in the final json
     *
     * @example
     *              path /aa/bb
     *              will be transformed to
     *              {
     *              aa : {
     *              bb: <VALUE OF RESOLVE>
     *              }
     *              }
     * @return mixed
     */
    public function getPath()
    {
        return 'request';
    }
}
