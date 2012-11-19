<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Terrific\Composition\DependencyInjection;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author Kris Wallsmith <kris@symfony.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();

        $builder->root('terrific_composition')
            ->children()
                ->scalarNode('node')->defaultValue('/usr/local/bin/node')->end()
                ->arrayNode('node_paths')
                    ->defaultValue(array('/usr/local/lib/node', '/usr/local/lib/node_modules'))
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $builder;
    }
}
