# profiler

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Quality Status][ico-scrutinizer]][link-scrutinizer]
[![Coverage Status][ico-coverage]][link-coverage]
[![SensioLabsInsight][ico-insight]][link-insight]

[![Build Status][ico-ndrx]][link-ndrx]

## Install

Via Composer

``` bash
$ composer require ndrx-io/profiler
```

## Usage

### Initialize a profiler

``` php
// build a new profiler
$profiler = ProfilerFactory::build([
    ProfilerFactory::OPTION_ENABLE => true,
    ProfilerFactory::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp',
    ProfilerFactory::OPTION_COLLECTORS => [
        \Ndrx\Profiler\Collectors\Data\PhpVersion::class,
        \Ndrx\Profiler\Collectors\Data\CpuUsage::class,
        \Ndrx\Profiler\Collectors\Data\Context::class,
        \Ndrx\Profiler\Collectors\Data\Timeline::class,
        \Ndrx\Profiler\Collectors\Data\Request::class,
        \Ndrx\Profiler\Collectors\Data\Log::class,
        \Ndrx\Profiler\Collectors\Data\Duration::class,
        // add other data collector ...
    ],

    /**
    * Ndrx\Profiler\Components\Logs\Monolog
    * or Ndrx\Profiler\Components\Logs\Simple available
    **/
    ProfilerFactory::OPTION_LOGGER => \Ndrx\Profiler\Components\Logs\Monolog::class
]);

// initialize the profiler
$profiler->initiate();

```

### Add event to the timeline

``` php
$profiler->start('foo', 'Bar');
$profiler->stop('foo');
$this->profiler->monitor('Foobar', function() {
   // very long process
});
```

### Logger

``` php
$profiler->debug('No beer');
$profiler->info('No beer');
$profiler->notice('No beer');
$profiler->alert('No beer');
$profiler->error('No beer');
$profiler->emergency('No beer');
$profiler->critical('No beer');
```

### Get last profils

``` php
$profiles = $profiler->getDatasource()->all(0, 10);
```

### Get Profil details

``` php
$id = '1576efef8ea36c74b533238affc3eaec7f94561d';
$profile = $profiler->getProfile($id);
```

### Clear all data

``` php
$profile = $profiler->getDatasource()->clear();
```

### Use monolog handler

``` php
$profiler = ProfilerFactory::build([
    // ...
    ProfilerFactory::LOGGER => Ndrx\Profiler\Components\Logs\Monolog::class
]);

// $log is your instance of Monolog\Logger
$log->pushHandler($profiler->getLogger();
```

## Add new Collector

All data collector must implements one of those interfaces:

- Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface For data available only at the end of the process, like response data
- Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface For data available at the beginning of the process, like request data
- Ndrx\Profiler\Collectors\Contracts\StreamCollectorInterface For data available during the process like logs, events, query...

### Initial collector
``` php
<?php

namespace /Your/Namespace;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\StartCollectorInterface;

class Foo extends Collector implements StartCollectorInterface
{
    /**
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {
        $this->data = 'bar';
    }

    /**
     * The path in the final json
     * @example
     *  path /aa/bb
     *  will be transformed to
     *  {
     *     aa : {
     *              bb: <VALUE OF RESOLVE>
     *       }
     *  }
     * @return string
     */
    public function getPath()
    {
        return 'foo';
    }
}
```

### Final collector

``` php
<?php

namespace /Your/Namespace;

use Ndrx\Profiler\Collectors\Collector;
use Ndrx\Profiler\Collectors\Contracts\FinalCollectorInterface;

class Foo extends Collector implements FinalCollectorInterface
{
    /**
     * Fetch data
     * @return mixed
     */
    public function resolve()
    {
        $this->data = 'bar';
    }

    /**
     * The path in the final json
     * @example
     *  path /aa/bb
     *  will be transformed to
     *  {
     *     aa : {
     *              bb: <VALUE OF RESOLVE>
     *       }
     *  }
     * @return string
     */
    public function getPath()
    {
        return 'foo';
    }
}
```

### Stream collector

Stream collector are a little bit more complex because you need to listen events and stream the event data to the datasource. 

``` php
<?php

namespace Ndrx\Profiler\Collectors\Data;

use Ndrx\Profiler\Collectors\StreamCollector;
use Ndrx\Profiler\Events\Log as LogEvent;
use Ndrx\Profiler\JsonPatch;

class Log extends StreamCollector
{

    protected function registerListeners()
    {
        // add a listener to your event dispatcher, the profiler has a build-in dispatcher than use can use
        $this->process->getDispatcher()->addListener(LogEvent::EVENT_NAME, function (LogEvent $event) {
            // fetch event data
            $this->data = $event->toArray();
            // stream to the data source
            $this->stream();
        });
    }

    /**
     * The path in the final json
     * @example
     *  path /aa/bb
     *  will be transformed to
     *  {
     *     aa : {
     *              bb: <VALUE OF RESOLVE>
     *       }
     *  }
     * @return mixed
     */
    public function getPath()
    {
        return 'logs';
    }

    /**
     * Write data in the datasource and clean current buffer
     * @return mixed
     */
    public function stream()
    {
        // generation of the json patch from data
        $patch = $this->jsonPatch->generate($this->getPath(), JsonPatch::ACTION_ADD, $this->data, true);
        // save the json patch in the datasource
        $this->dataSource->save($this->process, [$patch]);
        // clean data array to avoid duplicate entry
        $this->data = [];
    }
}
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email arnaud.lahaxe[at]versusmind.eu instead of using the issue tracker.

## Credits

- [LAHAXE Arnaud][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/ndrx/profiler.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ndrx-io/profiler/master.svg?style=flat-square
[ico-ndrx]: https://pbs.twimg.com/profile_images/585415130881642497/Qg4niE0o.png
[ico-scrutinizer]: https://scrutinizer-ci.com/g/ndrx-io/profiler/badges/quality-score.png?b=master
[ico-coverage]: https://scrutinizer-ci.com/g/ndrx-io/profiler/badges/coverage.png?b=master
[ico-insight]: https://insight.sensiolabs.com/projects/687eff4f-7bfb-4a0f-af5b-4786f7a614cf/mini.png


[link-packagist]: https://packagist.org/packages/ndrx/profiler
[link-travis]: https://travis-ci.org/ndrx-io/profiler
[link-author]: https://github.com/lahaxearnaud
[link-contributors]: ../../contributors
[link-ndrx]: http://ndrx.io
[link-scrutinizer]: https://scrutinizer-ci.com/g/ndrx-io/profiler/
[link-coverage]: https://scrutinizer-ci.com/g/ndrx-io/profiler/
[link-insight]: https://insight.sensiolabs.com/projects/687eff4f-7bfb-4a0f-af5b-4786f7a614cf
