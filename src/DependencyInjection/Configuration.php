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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

/**
 * ReCaptchaBundle configuration structure.
 *
 * @author Ilya Pokamestov <dario_swain@yahoo.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return NodeInterface
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('re_captcha');

        $rootNode
            ->children()
                ->scalarNode('js_api_url')->defaultValue('https://www.google.com/recaptcha/api.js')->end()
                ->scalarNode('public_key')->isRequired()->end()
                ->scalarNode('private_key')->isRequired()->end()
                ->scalarNode('locale')->defaultValue('en')->end()
                ->scalarNode('validator_class')->defaultValue('DS\ReCaptchaBundle\Validator\ReCaptchaValidator')->end()
                ->scalarNode('form_class')->defaultValue('DS\ReCaptchaBundle\Form\ReCaptchaType')->end()
                ->scalarNode('service_class')->defaultValue('DS\Library\ReCaptcha\ReCaptcha')->end()
                ->scalarNode('twig_class')->defaultValue('DS\ReCaptchaBundle\Twig\ReCaptchaExtension')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
