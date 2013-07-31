<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ConfigType
 *
 * @package Black\Bundle\ConfigBundle\Form\Type
 */
class ConfigType extends AbstractType
{
    private $class;

    /**
     * @param string $class The Person class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array(
                    'label' => 'config.admin.config.name.text'
                )
            )
            ->add(
                'value',
                'textarea',
                array(
                    'label' => 'config.admin.config.value.text'
                )
            )
            ->add(
                'protected',
                'checkbox',
                array(
                    'required'  => false,
                    'label'     => 'config.admin.config.protected.text'
                )
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    => $this->class,
                'intention'     => 'config_form'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'black_config_config';
    }
}