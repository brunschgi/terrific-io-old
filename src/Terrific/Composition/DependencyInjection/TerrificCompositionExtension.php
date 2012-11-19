<?php

namespace Terrific\Composition\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

class TerrificCompositionExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Parse configuration
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // Set parameter
        $container->setParameter('terrific_composition.node', $config['node']);
        $container->setParameter('terrific_composition.node_paths', $config['node_paths']);
    }

    public function getAlias()
    {
        return 'terrific_composition';
    }
}
