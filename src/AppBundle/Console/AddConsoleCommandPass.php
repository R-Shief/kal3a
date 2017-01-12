<?php

namespace AppBundle\Console;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddConsoleCommandPass.
 *
 * @see \Symfony\Bundle\FrameworkBundle\DependencyInjection\Compiler\AddConsoleCommandPass
 */
class AddConsoleCommandPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $applicationDefinition = $container->getDefinition('nab3a.console.application');
        $commandServices = $container->findTaggedServiceIds('nab3a.console.command');

        foreach ($commandServices as $id => $tags) {
            $definition = $container->getDefinition($id);

            if (!$definition->isPublic()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "nab3a.console.command" must be public.', $id));
            }

            if ($definition->isAbstract()) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "nab3a.console.command" must not be abstract.', $id));
            }

            $class = $container->getParameterBag()->resolveValue($definition->getClass());
            if (!is_subclass_of($class, 'Symfony\\Component\\Console\\Command\\Command')) {
                throw new \InvalidArgumentException(sprintf('The service "%s" tagged "nab3a.console.command" must be a subclass of "Symfony\\Component\\Console\\Command\\Command".', $id));
            }

            $applicationDefinition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
