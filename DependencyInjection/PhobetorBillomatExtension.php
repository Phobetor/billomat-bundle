<?php

namespace PhobetorBillomatBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use PhobetorBillomatBundle\Services\BillomatHandler;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PhobetorBillomatExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // fetch client list from configuration
        $clients = $config['clients'];

        // overwrite default client by top level configuration data
        foreach (array('id', 'api_key', 'application', 'wait_for_rate_limit_reset', 'async') as $attribute) {
            $clients[BillomatHandler::DEFAULT_CLIENT_NAME][$attribute] = $config[$attribute];
        }

        $container->setParameter('phobetor_billomat.clients', $clients);
    }
}
