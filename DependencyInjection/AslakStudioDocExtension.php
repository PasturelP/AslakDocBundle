<?php

namespace AslakStudio\DocBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AslakStudioDocExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration,$configs);
        foreach($config as $tag => $val)
            if(is_array($val))
                foreach($val as $key => $value)
                    $container->setParameter( 'aslak_doc.'.$tag.'.'.$key, $value);
            else
                $container->setParameter( 'aslak_doc.'.$tag, $val);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
