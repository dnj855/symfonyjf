<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new ServiceJF\CoreBundle\ServiceJFCoreBundle(),
            new ServiceJF\ChallengeCIBundle\ServiceJFChallengeCIBundle(),
            new ServiceJF\ChallengeFGBundle\ServiceJFChallengeFGBundle(),
            new ServiceJF\MigrationBundle\ServiceJFMigrationBundle(),
            new ServiceJF\AdminBundle\ServiceJFAdminBundle(),
            new ServiceJF\ChallengeDLBundle\ServiceJFChallengeDLBundle(),
            new ServiceJF\ChallengePSBundle\ServiceJFChallengePSBundle(),
            new ServiceJF\ChallengeCSSBundle\ServiceJFChallengeCSSBundle(),
            new ServiceJF\ChallengeCM18Bundle\ServiceJFChallengeCM18Bundle(),
            new Debril\RssAtomBundle\DebrilRssAtomBundle(),
            new ServiceJF\UserBundle\ServiceJFUserBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new ServiceJF\JeudiBundle\ServiceJFJeudiBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
