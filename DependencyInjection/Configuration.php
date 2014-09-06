<?php

namespace PhobetorBillomatBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
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

        $rootNode
            ->children()
                ->scalarNode('id')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Your Billomat Id')
                    ->example('company_name')
                ->end()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->info('Your Billomat API key')
                    ->example('12345abc67890def12345abc67890def')
                ->end()
                ->booleanNode('wait_for_rate_limit_reset')
                    ->defaultFalse()
                    ->info('Wait for rate limit reset if rate limit is reached during a request')
                ->end()
                ->booleanNode('async')
                    ->defaultFalse()
                    ->info('Use asynchronous requests with the Guzzle Async Plugin')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
