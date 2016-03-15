<?php

/*
 * This file is part of the DSReCaptcha Bundle.
 *
 * (c) Ilya Pokamestov <dario_swain@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace DS\ReCaptchaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This compiler pass injects the Request object into the ReCaptchaValidator
 */
class ReCaptchaValidatorPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('ds_re_captcha.validator')) {
            $definition = $container->getDefinition('ds_re_captcha.validator');

            // The @request_stack service was added in Symfony 2.4
            if ($container->hasDefinition('request_stack')) {
                $definition->replaceArgument(0, new Reference('request_stack'));
            } else {
                $definition->replaceArgument(0, new Reference('request'));
            }

            // Scoped services are deprecated in Symfony 2.8 and removed in Symfony 3.0
            if (method_exists($definition, 'setScope')) {
                $definition->setScope('request');
            }
        }
    }
}
