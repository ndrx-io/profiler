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
$profiler = \Ndrx\Profiler\Profiler::getInstance();

// add a datasource
$profiler->setDataSource(new \Ndrx\Profiler\DataSources\File('/tmp/profiler'));

// create a logger Simple or Monolog
$logger = new \Ndrx\Profiler\Components\Logs\Simple();
// set the dispatcher on the logger
$logger->setDispatcher($profiler->getContext()->getProcess()->getDispatcher());
$profiler->setLogger($logger);

// register some data collector
$profiler->registerCollectorClasses([
    Ndrx\Profiler\Collectors\Data\PhpVersion::class,
    Ndrx\Profiler\Collectors\Data\CpuUsage::class,
    Ndrx\Profiler\Collectors\Data\Context::class,
    Ndrx\Profiler\Collectors\Data\Timeline::class,
    Ndrx\Profiler\Collectors\Data\Request::class,
    Ndrx\Profiler\Collectors\Data\Log::class,
    Ndrx\Profiler\Collectors\Data\Duration::class,
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

### Use monolog handler

``` php
// create a logger Monolog
$logger = new \Ndrx\Profiler\Components\Logs\Monolog();
// set the dispatcher on the logger
$logger->setDispatcher($profiler->getContext()->getProcess()->getDispatcher());
$profiler->setLogger($logger);

// $log is your instance of Monolog\Logger
$log->pushHandler($logger);
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

[ico-version]: https://img.shields.io/packagist/v/ndrx-io/profiler.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/ndrx-io/profiler/master.svg?style=flat-square
[ico-ndrx]: https://pbs.twimg.com/profile_images/585415130881642497/Qg4niE0o.png
[ico-scrutinizer]: https://scrutinizer-ci.com/g/ndrx-io/profiler/badges/quality-score.png?b=master
[ico-coverage]: https://scrutinizer-ci.com/g/ndrx-io/profiler/badges/coverage.png?b=master
[ico-insight]: https://insight.sensiolabs.com/projects/687eff4f-7bfb-4a0f-af5b-4786f7a614cf/mini.png


[link-packagist]: https://packagist.org/packages/ndrx-io/profiler
[link-travis]: https://travis-ci.org/ndrx-io/profiler
[link-author]: https://github.com/lahaxearnaud
[link-contributors]: ../../contributors
[link-ndrx]: http://ndrx.io
[link-scrutinizer]: https://scrutinizer-ci.com/g/ndrx-io/profiler/
[link-coverage]: https://scrutinizer-ci.com/g/ndrx-io/profiler/
[link-insight]: https://insight.sensiolabs.com/projects/687eff4f-7bfb-4a0f-af5b-4786f7a614cf
