<?php

namespace AppBundle\Guzzle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\Reference;

class StackMiddlewareCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $serviceIds = $container->findTaggedServiceIds('guzzle.middleware');
        $stacks = [];
        /**
         * @var string $serviceId
         * @var array $tags
         */
        foreach ($serviceIds as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $clientId = $tag['client'];
                unset($tag['client']);
                $stacks[$clientId][] = array_merge(['method' => 'push'], $tag, ['service' => $serviceId]);
            }
        }

        foreach ($stacks as $clientId => $middlewares) {
            try {
                $clientDefinition = $container->getDefinition($clientId);
            } catch (ServiceNotFoundException $e) {
                continue;
            }
            $arguments = $clientDefinition->getArguments();

            $handlerDefinition = self::hasHandlerDefinition($arguments) ? self::getHandlerDefinition($arguments) : self::newHandlerDefinition($container);

            $stackDefinition = new DefinitionDecorator('nab3a.guzzle.handler_stack');
            $stackDefinition->setArguments([$handlerDefinition]);
            $earlyMiddleware = array_filter($middlewares, function ($middleware) {
                return !array_key_exists('before', $middleware) && !array_key_exists('after', $middleware);
            });
            $lateMiddleware = array_diff_key($middlewares, $earlyMiddleware);
            foreach ($earlyMiddleware + $lateMiddleware as $middleware) {
                $method = $middleware['method'];
                $stackArguments = [
                  new Reference($middleware['service']),
                  $middleware['middleware_name'],
                ];
                if (isset($middleware['before']) || isset($middleware['after'])) {
                    $method = isset($middleware['before']) ? 'before' : 'after';
                    array_unshift($stackArguments, $middleware[$method]);
                }

                $stackDefinition->addMethodCall($method, $stackArguments);
            }

            $arguments[0]['handler'] = $stackDefinition;

            $clientDefinition->setArguments($arguments);
            $container->setDefinition($clientId, $clientDefinition);
        }
    }

    private static function hasHandlerDefinition(array $arguments = [[]])
    {
        return isset($arguments[0]['handler']);
    }

    /**
     * @param array $arguments
     *
     * @return Definition
     */
    private static function getHandlerDefinition(array $arguments = [[]])
    {
        return $arguments[0]['handler'];
    }

    /**
     * @see \GuzzleHttp\choose_handler()
     *
     * @param ContainerBuilder $container
     *
     * @return null|Definition
     */
    private static function newHandlerDefinition(ContainerBuilder $container)
    {
        $definition = new Definition();
        $definition->setFactory('GuzzleHttp\choose_handler');

        return $definition;
    }
}
