<?php
/**
 * User: cedriclangroth
 * Date: 21/04/2018
 * Time: 13:20
 */

namespace ServiceJF\ChallengeDLBundle\GamePhase;

use Doctrine\ORM\EntityManager;



class PointsChecker
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function checkPoints() {
        $gamePhaseRepository = $this->em->getRepository("ServiceJF\ChallengeDLBundle\Entity\GamePhase");
        $points = $gamePhaseRepository->findAll();
        foreach ($points as $point) {
            if ($point->getPoints() != NULL) {
                return 1;
                break;
            }
        }
        return 0;
    }
}