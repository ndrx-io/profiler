<?php

namespace Ndrx\Profiler;

use Ndrx\Profiler\Collectors\Data\CpuUsage;
use Ndrx\Profiler\Collectors\Data\Log;
use Ndrx\Profiler\Collectors\Data\PhpVersion;
use Ndrx\Profiler\Collectors\Data\Request;
use Ndrx\Profiler\Collectors\Data\Timeline;
use Ndrx\Profiler\Components\Logs\Monolog;
use Ndrx\Profiler\Components\Logs\Simple;
use Ndrx\Profiler\DataSources\File;
use Ndrx\Profiler\DataSources\Memory;
use Ndrx\Profiler\Components\Timeline as TimelineComponent;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\NoSuchOptionException;
use Symfony\Component\OptionsResolver\Exception\OptionDefinitionException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Exception\AccessException;

/**
 * Class ProfilerFactory
 * @package Ndrx\Profiler
 */
class ProfilerFactory
{
    const OPTION_ENABLE = 'enable';
    const OPTION_ENVIRONMENT = 'environment';
    const OPTION_DATASOURCE_PROFILES_FOLDER = 'dataSourceProfilesFolders';
    const OPTION_DATASOURCE_CLASS = 'dataSourceClass';
    const OPTION_LOGGER = 'logger';
    const OPTION_COLLECTORS = 'collectors';

    /**
     * @var ProfilerInterface
     */
    protected static $profiler;

    /**
     * @return ProfilerInterface
     * @throws \RuntimeException
     */
    public static function getProfiler()
    {
        if (self::$profiler === null) {
            throw new \RuntimeException('Before getting profiler you need to create one');
        }

        return self::$profiler;
    }

    /**
     * @param array $options
     * @return Profiler|ProfilerInterface
     * @throws \RuntimeException
     * @throws AccessException
     * @throws UndefinedOptionsException
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws NoSuchOptionException
     * @throws OptionDefinitionException
     */
    public static function build(array $options = [])
    {
        self::$profiler = (new self())->create($options);

        return self::$profiler;
    }

    /**
     * @param array $options
     * @return Profiler
     *
     * @throws \RuntimeException
     * @throws AccessException
     * @throws UndefinedOptionsException
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws NoSuchOptionException
     * @throws OptionDefinitionException
     */
    public function create(array $options = [])
    {
        $options = $this->resolveOptions($options);

        if (!$options[self::OPTION_ENABLE]) {
            return new NullProfiler();
        }

        if ($options[self::OPTION_ENVIRONMENT] !== null) {
            Profiler::$environment = $options[self::OPTION_ENVIRONMENT];
        }

        $profiler = new Profiler();

        $datasource = null;
        switch ($options[self::OPTION_DATASOURCE_CLASS]) {
            default:
            case File::class:
                $datasource = new File($options[self::OPTION_DATASOURCE_PROFILES_FOLDER]);
                break;
            case Memory::class:
                $datasource = new Memory();
        }

        $profiler->setDataSource($datasource);
        $profiler->registerCollectorClasses($options[self::OPTION_COLLECTORS]);

        $dispatcher = $profiler->getContext()->getProcess()->getDispatcher();
        $className = $options['logger'];
        $logger = new $className();
        $logger->setDispatcher($dispatcher);
        $profiler->setLogger($logger);

        $profiler->setTimeline(new TimelineComponent($dispatcher));

        return $profiler;
    }


    /**
     * @param array $options
     * @return array
     * @throws AccessException
     * @throws UndefinedOptionsException
     * @throws MissingOptionsException
     * @throws InvalidOptionsException
     * @throws NoSuchOptionException
     * @throws OptionDefinitionException
     */
    protected function resolveOptions(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        return $resolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     * @throws AccessException
     * @throws UndefinedOptionsException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            self::OPTION_ENABLE => true,
            self::OPTION_ENVIRONMENT => null,
            self::OPTION_DATASOURCE_PROFILES_FOLDER => '/tmp/profiler/',
            self::OPTION_DATASOURCE_CLASS => File::class,
            self::OPTION_LOGGER => Simple::class,
            self::OPTION_COLLECTORS => [
                CpuUsage::class,
                Log::class,
                PhpVersion::class,
                Timeline::class,
                Request::class
            ],
        ]);

        $resolver->setAllowedTypes(self::OPTION_DATASOURCE_PROFILES_FOLDER, 'string');
        $resolver->setAllowedValues(self::OPTION_LOGGER, [Monolog::class, Simple::class]);
        $resolver->setAllowedTypes(self::OPTION_COLLECTORS, 'array');
        $resolver->setAllowedTypes(self::OPTION_ENABLE, 'boolean');
        $resolver->setAllowedValues(self::OPTION_DATASOURCE_CLASS, [File::class, Memory::class]);
    }
}
