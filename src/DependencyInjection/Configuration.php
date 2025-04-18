<?php

namespace EasyAdminFriends\EasyAdminDashboardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('easy_admin_dashboard');
        $rootNode = $treeBuilder->getRootNode();

        $this->addDashboardSection($rootNode);

        return $treeBuilder;
    }

    private function addDashboardSection(ArrayNodeDefinition $rootNode):void
    {
        $rootNode
            ->children()
                ->scalarNode('title')
                    ->defaultValue('Welcome')
                    ->info('The title displayed at the top of the dashboard page.')
                ->end()
                ->scalarNode('layout')->defaultNull()->end()

                ->arrayNode('blocks')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('label')->defaultNull()->end()
                            ->integerNode('size')->defaultValue(12)->end()
                            ->scalarNode('css_class')->defaultValue('')->end()
                            ->arrayNode('permissions')
                                ->scalarPrototype()->end()
                                ->defaultValue([])
                            ->end()

                            ->arrayNode('items')
                                ->useAttributeAsKey('name')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('label')->defaultNull()->end()
                                        ->integerNode('size')->defaultValue(4)->end()
                                        ->scalarNode('css_class')->defaultValue('')->end()
                                        ->scalarNode('class')->isRequired()->end()
                                        ->scalarNode('controller')->isRequired()->end()
                                        ->scalarNode('icon')->defaultNull()->end()
                                        ->scalarNode('link_label')->defaultNull()->end()
                                        ->scalarNode('dql_filter')->defaultNull()->end()
                                        ->scalarNode('query')->defaultNull()->end()
                                        ->arrayNode('permissions')
                                            ->scalarPrototype()->end()
                                            ->defaultValue([])
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()

                        ->end()
                    ->end()
                ->end()

            ->end();

    }
}
