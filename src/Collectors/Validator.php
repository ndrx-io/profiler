<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 12/11/15
 * Time: 20:21
 */

namespace Ndrx\Profiler\Collectors;

use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\NoSuchOptionException;
use Symfony\Component\OptionsResolver\Exception\OptionDefinitionException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Validator
{
    /**
     * @var OptionsResolver
     */
    protected $optionResolver;

    public function __construct(array $required, array $defaults = array())
    {
        $this->optionResolver = new OptionsResolver();
        $this->optionResolver->setDefaults(array_fill_keys($required, null));
        $this->optionResolver->setRequired($required);
    }

    /**
     * @param array $data
     * @throws UndefinedOptionsException If an option name is undefined
     * @throws InvalidOptionsException   If an option doesn't fulfill the
     *                                   specified validation rules
     * @throws MissingOptionsException   If a required option is missing
     * @throws OptionDefinitionException If there is a cyclic dependency between
     *                                   lazy options and/or normalizers
     * @throws NoSuchOptionException     If a lazy option reads an unavailable option
     * @throws AccessException           If called from a lazy option or normalizer
     * @return bool
     */
    public function validate(array $data)
    {
        $this->optionResolver->resolve($data);
        $this->optionResolver->clear();

        return true;
    }
}