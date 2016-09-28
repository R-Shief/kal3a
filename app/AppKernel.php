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
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new Bangpound\Atom\DataBundle\BangpoundAtomDataBundle(),
            new Bangpound\Bundle\CastleBundle\BangpoundCastleBundle(),
            new Bangpound\Bundle\CastleSearchBundle\BangpoundCastleSearchBundle(),
            new Bangpound\Bundle\GuzzleProxyBundle\BangpoundGuzzleProxyBundle(),
            new RShief\Nab3aBundle\Nab3aBundle(),
            new Bangpound\Bundle\TwitterStreamingBundle\BangpoundTwitterStreamingBundle(),
            new Doctrine\Bundle\CouchDBBundle\DoctrineCouchDBBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Liip\MonitorBundle\LiipMonitorBundle(),
            new Nelmio\CorsBundle\NelmioCorsBundle(),
            new OldSound\RabbitMqBundle\OldSoundRabbitMqBundle(),
            new Rshief\Bundle\Kal3aBundle\RshiefKal3aBundle(),
            new ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new \YZ\SupervisorBundle\YZSupervisorBundle(),
            new \Aws\Symfony\AwsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }

    public function getCacheDir()
    {
        return $this->rootDir.'/../var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->rootDir.'/../var/logs';
    }
}
