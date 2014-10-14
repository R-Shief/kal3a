<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new OldSound\RabbitMqBundle\OldSoundRabbitMqBundle(),
            new Bangpound\PhirehoseBundle\BangpoundPhirehoseBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Application\UserBundle\ApplicationUserBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Bangpound\Bundle\TwitterStreamingBundle\BangpoundTwitterStreamingBundle(),
            new Doctrine\Bundle\CouchDBBundle\DoctrineCouchDBBundle(),
            new Liip\MonitorBundle\LiipMonitorBundle(),
            new Ddeboer\DataImportBundle\DdeboerDataImportBundle(),
            new Rshief\Bundle\MigrationBundle\RshiefMigrationBundle(),
            new Bangpound\Atom\DataBundle\BangpoundAtomDataBundle(),
            new Ushios\Bundle\ElasticSearchBundle\UshiosElasticSearchBundle(),
            new Sputnik\Bundle\PubsubBundle\SputnikPubsubBundle(),
            new Bangpound\Bundle\PubsubBundle\BangpoundPubsubBundle(),
            new Bangpound\Bundle\CastleBundle\BangpoundCastleBundle(),
            new Bangpound\Bundle\CastleSearchBundle\BangpoundCastleSearchBundle(),
            new Bangpound\Bundle\GuzzleProxyBundle\BangpoundGuzzleProxyBundle(),
            new Rshief\Bundle\Kal3aBundle\RshiefKal3aBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new Sp\BowerBundle\SpBowerBundle(),
            new Bangpound\Bundle\AngularJsBundle\BangpoundAngularJsBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new Application\AssetsBundle\ApplicationAssetsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle();
            $bundles[] = new Bangpound\Bundle\InvokerBundle\BangpoundInvokerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
