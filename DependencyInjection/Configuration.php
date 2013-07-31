<?php

/*
 * This file is part of the Blackengine package.
 *
 * (c) Alexandre Balmes <albalmes@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Black\Bundle\ConfigBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * BlackEngine Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('black_config');

        $supportedDrivers = array('mongodb', 'orm');

        $rootNode
            ->children()

                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The database driver must be either \'mongodb\', \'orm\'.')
                    ->end()
                ->end()

                ->scalarNode('config_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('config_manager')
                    ->defaultValue('Black\\Bundle\\ConfigBundle\\Doctrine\\ConfigManager')
                ->end()
            ->end();

        $this->addConfigSection($rootNode);

        return $treeBuilder;
    }

    private function addConfigSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('config')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('main_name')->defaultValue('black_config')->end()
                                ->scalarNode('main_type')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Type\\ConfigType'
                                )->end()
                                ->scalarNode('main_handler')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Handler\\ConfigFormHandler'
                                )->end()
                                ->scalarNode('general_name')->defaultValue('black_config_general')->end()
                                ->scalarNode('general_type')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Type\\GeneralConfigType'
                                )->end()
                                ->scalarNode('general_handler')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Handler\\ConfigFormHandler'
                                )->end()
                                ->scalarNode('mail_name')->defaultValue('black_config_config')->end()
                                ->scalarNode('mail_type')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Type\\MailConfigType'
                                )->end()
                                ->scalarNode('mail_handler')->defaultValue(
                                    'Black\\Bundle\\ConfigBundle\\Form\\Handler\\ConfigFormHandler'
                                )->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}