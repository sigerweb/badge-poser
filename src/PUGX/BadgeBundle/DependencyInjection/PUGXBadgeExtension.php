<?php

/*
 * This file is part of the badge-poser package.
 *
 * (c) PUGX <http://pugx.github.io/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PUGX\BadgeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PUGXBadgeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('packagist.xml');
        if (!$config['disable_cache']) {
            $loader->load('packagist_cache.xml');
        }

        $loader->load('shieldio.xml');
        if (!$config['disable_cache']) {
            $loader->load('shieldio_cache.xml');
        }

        $loader->load('snippet.xml');

        $container->setParameter($this->getAlias().'.badges', $config['badges']);
        $container->setParameter($this->getAlias().'.allin_badges', $config['allin_badges']);
    }
}
