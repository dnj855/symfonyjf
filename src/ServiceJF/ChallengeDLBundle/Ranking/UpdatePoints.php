<?php
/**
 * User: cedriclangroth
 * Date: 22/04/2018
 * Time: 21:54
 */

namespace ServiceJF\ChallengeDLBundle\Ranking;

use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeDLBundle\Entity\Personality;


class UpdatePoints
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function updatePoints(Personality $personality)
    {
        $points = 100 - $personality->getAge();
        $betsRepository = $this->em->getRepository('ServiceJF\ChallengeDLBundle\Entity\ValidBet');
        $bets = $betsRepository->findBy(array(
            'personality' => $personality
        ));
        foreach ($bets as $bet) {
            $score = $bet->getGamePhase()->getPoints();
            if ($bet->getJoker() == true) {
                $score = $score + $points * 2;
            } else {
                $score = $score + $points;
            }
            $bet->getGamePhase()->setPoints($score);
        }
        $this->em->flush();
    }
}