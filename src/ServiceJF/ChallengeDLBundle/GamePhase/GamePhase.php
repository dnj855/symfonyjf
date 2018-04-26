<?php
/**
 * User: cedriclangroth
 * Date: 18/03/2018
 * Time: 10:13
 */

namespace ServiceJF\ChallengeDLBundle\GamePhase;

use Doctrine\ORM\EntityManager;
use ServiceJF\UserBundle\Entity\User;

class GamePhase
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getGamePhase(User $user)
    {
        $gamePhaseRepository = $this->em->getRepository("ServiceJF\ChallengeDLBundle\Entity\GamePhase");
        $gamePhase = $gamePhaseRepository->findOneBy(array(
            'better' => $user
        ));
        if ($gamePhase != null) {
            if ($gamePhase->getCuratedBet() != null) {
                return 'curatedBet';
            } elseif ($gamePhase->getValidBet() != null) {
                return 'validBet';
            } else {
                return 'stillBetting';
            }
        } else {
            return 'newPlayer';
        }
    }
}