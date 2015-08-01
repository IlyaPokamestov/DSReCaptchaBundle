<?php

/*
 * This file is part of the ReCaptcha Bundle.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\ReCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * ReCaptchaBundle extension.
 *
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class ReCaptchaExtension extends Extension
{
    /**
     * {@inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $this->setParameters($container, $config);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     * @return ContainerBuilder
     */
    protected function setParameters(ContainerBuilder $container, array $config)
    {
        foreach ($config as $key => $value) {
            if (null === $value)
            {
                throw new InvalidConfigurationException(sprintf('Parameter "%s" will be configured in "%s" section', $key, $this->getAlias()));
            }

            $container->setParameter(sprintf('%s.%s', $this->getAlias(), $key), $value);
        }

        return $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 're_captcha';
    }
}
