<?php

namespace Xsolve\NewsletterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $builder->root('xsolve_newsletter')
                ->children()
                    ->scalarNode('send_key')->defaultValue('testkey')->end()
                    ->scalarNode('tasks_per_time')->defaultValue(1)->end()
                    ->scalarNode('from_mail')->end()
                    ->scalarNode('from_name')->end()
                ->end();

        return $builder;
    }

}
