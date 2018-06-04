<?php
/**
 * User: cedriclangroth
 * Date: 12/05/2018
 * Time: 10:17
 */

namespace ServiceJF\ChallengeCM18Bundle\Services;


use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeCM18Bundle\Entity\Game;

class BetOdds
{
    private $em;

    private $betsHome;

    private $betsAway;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findBetOdds(Game $game)
    {
        $this->betsHome = null;
        $this->betsAway = null;
        $bets = $game->getBets();
        if (sizeof($bets) == 0) {
            return false;
        } else {
            $this->betsHome = 0;
            $this->betsAway = 0;
        }
        foreach ($bets as $bet) {
            $this->betsHome += $bet->getBetHome();
            $this->betsAway += $bet->getBetAway();
        }
        $this->betsHome = $this->betsHome / sizeof($bets);
        $this->betsAway = $this->betsAway / sizeof($bets);
    }

    /**
     * @return int
     */
    public function getBetsHome()
    {
        return $this->betsHome;
    }

    /**
     * @return int
     */
    public function getBetsAway()
    {
        return $this->betsAway;
    }
}