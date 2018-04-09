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
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('easy_admin_dashboard');

        $this->addDashboardSection($rootNode);

        return $treeBuilder;
    }

    private function addDashboardSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode('title')
                    ->defaultValue('Welcome')
                    ->info('The title displayed at the top of dashboard page.')
                ->end()
                ->arrayNode('blocks')
                    ->normalizeKeys(false)
                    ->useAttributeAsKey('name', false)
                    ->defaultValue(array())
                    ->info('The list of blocks to display in the dashboard page.')
                    ->prototype('variable')
                ->end()
            ->end()
        ;
    }
}
