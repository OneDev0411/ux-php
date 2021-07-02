<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\UX\LiveComponent\DependencyInjection;

use Symfony\Component\DependencyInjection\Argument\AbstractArgument;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentValidator;
use Symfony\UX\LiveComponent\ComponentValidatorInterface;
use Symfony\UX\LiveComponent\DependencyInjection\Compiler\LiveComponentPass;
use Symfony\UX\LiveComponent\EventListener\LiveComponentSubscriber;
use Symfony\UX\LiveComponent\Hydrator\DoctrineEntityPropertyHydrator;
use Symfony\UX\LiveComponent\Hydrator\NormalizerBridgePropertyHydrator;
use Symfony\UX\LiveComponent\LiveComponentHydrator;
use Symfony\UX\LiveComponent\PropertyHydratorInterface;
use Symfony\UX\LiveComponent\Twig\LiveComponentExtension as LiveComponentTwigExtension;
use Symfony\UX\LiveComponent\Twig\LiveComponentRuntime;
use Symfony\UX\TwigComponent\ComponentRenderer;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 *
 * @experimental
 */
final class LiveComponentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        if (method_exists($container, 'registerAttributeForAutoconfiguration')) {
            $container->registerAttributeForAutoconfiguration(AsLiveComponent::class, function (ChildDefinition $definition) {
                $definition
                    ->addTag('twig.component')
                    ->addTag('controller.service_arguments')
                ;
            });
        }

        $container->registerForAutoconfiguration(PropertyHydratorInterface::class)
            ->addTag('twig.component.property_hydrator')
        ;

        $container->register('ux.live_component.doctrine_entity_property_hydrator', DoctrineEntityPropertyHydrator::class)
            ->setArguments([[new Reference('doctrine')]])
            ->addTag('twig.component.property_hydrator', ['priority' => -200])
        ;

        $container->register('ux.live_component.datetime_property_hydrator', NormalizerBridgePropertyHydrator::class)
            ->setArguments([new Reference('serializer.normalizer.datetime')])
            ->addTag('twig.component.property_hydrator', ['priority' => -100])
        ;

        $container->register('ux.live_component.component_hydrator', LiveComponentHydrator::class)
            ->setArguments([
                new TaggedIteratorArgument('twig.component.property_hydrator'),
                new Reference('property_accessor'),
                '%kernel.secret%',
            ])
        ;

        $container->register('ux.live_component.event_subscriber', LiveComponentSubscriber::class)
            ->setArguments([
                class_exists(AbstractArgument::class) ? new AbstractArgument(sprintf('Added in %s.', LiveComponentPass::class)) : [],
            ])
            ->addTag('kernel.event_subscriber')
            ->addTag('container.service_subscriber', ['key' => ComponentRenderer::class, 'id' => 'ux.twig_component.component_renderer'])
            ->addTag('container.service_subscriber', ['key' => LiveComponentHydrator::class, 'id' => 'ux.live_component.component_hydrator'])
            ->addTag('container.service_subscriber')
        ;

        $container->register('ux.live_component.twig.component_extension', LiveComponentTwigExtension::class)
            ->addTag('twig.extension')
        ;

        $container->register('ux.live_component.twig.component_runtime', LiveComponentRuntime::class)
            ->setArguments([
                new Reference('ux.live_component.component_hydrator'),
                new Reference(UrlGeneratorInterface::class),
                new Reference(CsrfTokenManagerInterface::class, ContainerBuilder::NULL_ON_INVALID_REFERENCE),
            ])
            ->addTag('twig.runtime')
        ;

        $container->register(ComponentValidator::class)
            ->addTag('container.service_subscriber', ['key' => 'validator', 'id' => 'validator'])
        ;

        $container->setAlias(ComponentValidatorInterface::class, ComponentValidator::class);
    }
}
