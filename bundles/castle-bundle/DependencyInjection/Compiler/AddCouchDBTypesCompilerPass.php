<?php

namespace Bangpound\Bundle\CastleBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class AddCouchDBTypesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $resolver = new Definition('Bangpound\Bundle\CastleBundle\MetadataResolver\DoctrineResolver');

        $definition = $container->getDefinition('doctrine_couchdb.odm.default_configuration');
        $definition->addMethodCall('setMetadataResolverImpl', [ $resolver ]);
    }
}
