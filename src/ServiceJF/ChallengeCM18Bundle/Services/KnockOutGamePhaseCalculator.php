<?php
/**
 * User: cedriclangroth
 * Date: 11/05/2018
 * Time: 18:09
 */

namespace ServiceJF\ChallengeCM18Bundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KnockOutGamePhaseCalculator
{
    private $em;

    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function getGamePhase(\DateTime $now)
    {
        $gamePhaseRepository = $this->em->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\GamePhase');
        if ($now > new \DateTime($this->container->getParameter('cm18_endLittleFinal'))) {
            return $gamePhaseRepository->findOneBy(array(
                'name' => 'Finale'
            ));
        } elseif ($now > new \DateTime($this->container->getParameter('cm18_endSemiFinals'))) {
            return $gamePhaseRepository->findOneBy(array(
                'name' => 'Petite finale'
            ));
        } elseif ($now > new \DateTime($this->container->getParameter('cm18_endQuarterFinals'))) {
            return $gamePhaseRepository->findOneBy(array(
                'name' => 'Demi-finale'
            ));
        } elseif ($now > new \DateTime($this->container->getParameter('cm18_endRoundOf16'))) {
            return $gamePhaseRepository->findOneBy(array(
                'name' => 'Quart de finale'
            ));
        } else {
            return $gamePhaseRepository->findOneBy(array(
                'name' => '8è de finale'
            ));
        }
    }
}