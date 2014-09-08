<?php

namespace PhobetorBillomatBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('phobetor_billomat');
        $children = $rootNode
            ->fixXmlConfig('child', 'children')
            ->children();

        $this->addClientsConfiguration($children);
        $this->addClientConfiguration($children);

        return $treeBuilder;
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\NodeBuilder $node
     */
    private function addClientsConfiguration(NodeBuilder $node) {
        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $array */
        $array = $node
            ->arrayNode('clients')
                ->useAttributeAsKey('name')
                ->prototype('array');

        $children = $array->children();

        $this->addClientConfiguration($children);
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\NodeBuilder $node
     */
    private function addClientConfiguration(NodeBuilder $node) {
        $node
            ->scalarNode('id')
                ->isRequired()
                ->cannotBeEmpty()
                ->info('Your Billomat Id')
                ->example('company_name');
        $node
            ->scalarNode('api_key')
                ->isRequired()
                ->cannotBeEmpty()
                ->info('Your Billomat API key')
                ->example('12345abc67890def12345abc67890def');

        $children = $node
            ->arrayNode('application')
                ->addDefaultsIfNotSet()
                ->children();
        $this->addApplicationConfiguration($children);

        $node
            ->booleanNode('wait_for_rate_limit_reset')
                ->defaultFalse()
                ->info('Wait for rate limit reset if rate limit is reached during a request');
        $node
            ->booleanNode('async')
                ->defaultFalse()
                ->info('Use asynchronous requests with the Guzzle Async Plugin');
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\NodeBuilder $node
     */
    private function addApplicationConfiguration(NodeBuilder $node) {
        $node
            ->scalarNode('id')
                ->defaultNull()
                ->info('Your Billomat API application’s id')
                ->example('1234');
        $node
            ->scalarNode('secret')
                ->defaultNull()
                ->info('Your Billomat API application’s secret')
                ->example('12345abc67890def12345abc67890def');
    }
}
