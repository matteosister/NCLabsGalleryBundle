<?php

namespace NCLabs\Bundle\GalleryBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class NCLabsGalleryExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('controller.xml');
        $loader->load('services.xml');

        $config = $this->mergeConfig($configs);

        if (isset($config['gallery']))
        {
            $this->processGalleryConfig($config['gallery'], $container);
        }
    }

    public function getAlias()
    {
        return 'nc_labs_gallery';
    }

    protected function processGalleryConfig(array $config, ContainerBuilder $container)
    {
        $alias = $this->getAlias();
        $options = array('root_dir', 'archive_cache_dir');
        $serviceID = 'controller.gallery';

        $this->processConfig($config, $container, $options, $serviceID);
    }

    public function mergeConfig(array $config)
    {
        $configuration = array();
        foreach ($config as $c)
        {
            $configuration = array_merge($configuration, $c);
        }

        return $configuration;
    }

    public function processConfig(array $config, ContainerBuilder $container, $options, $serviceID)
    {
        $alias = $this->getAlias();

        foreach ($options as $key)
        {
            if (isset($config[$key]))
            {
                $container->setParameter($alias . '.' . $serviceID . '.' . $key, $config[$key]);
            }
        }
    }
}
