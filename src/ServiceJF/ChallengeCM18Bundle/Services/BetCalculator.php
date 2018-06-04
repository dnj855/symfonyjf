<?php
/**
 * User: cedriclangroth
 * Date: 27/05/2018
 * Time: 18:55
 */

namespace ServiceJF\ChallengeCM18Bundle\Services;


use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeCM18Bundle\Entity\Bet;
use ServiceJF\ChallengeCM18Bundle\Entity\Game;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BetCalculator
{
    private $em;
    private $container;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;

    }

    public function calculate(Bet $bet, Game $game)
    {
        $bet->setPoints(0);
        $player = $bet->getPlayer();
        if ($bet->getResult() == $game->getResult()) {
            $bet->setPoints($this->container->getParameter('cm18_points_1n2'));
            $player->setPoints($player->getPoints() + $this->container->getParameter('cm18_points_1n2'));
            if ($bet->getBetHome() == $game->getScoreHome() && $bet->getBetAway() == $game->getScoreAway()) {
                $player->setPoints($player->getPoints() + $this->container->getParameter('cm18_points_perfect'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('cm18_points_perfect'));
                $player->setPerfect($player->getPerfect() + 1);
            }
            if ($game->getGamePhase()->getEliminatory() && $bet->getWinner() == $game->getWinner()) {
                $player->setPoints($player->getPoints() + $this->container->getParameter('cm18_points_koWinner'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('cm18_points_koWinner'));
            }
        }
        if ($game->getGamePhase()->getFinal()) {
            if ($game->getWinner() == 'home') {
                $finalWinner = $game->getTeamHome();
            } else {
                $finalWinner = $game->getTeamAway();
            }
            if ($finalWinner == $player->getFinalBet()) {
                $player->setPoints($player->getPoints() + $this->container->getParameter('cm18_points_finalWinner'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('cm18_points_finalWinner'));
            }
        }
        $this->em->persist($bet);
        $this->em->flush();
    }
}