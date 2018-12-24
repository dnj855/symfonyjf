<?php
/**
 * User: cedriclangroth
 * Date: 27/05/2018
 * Time: 18:55
 */

namespace ServiceJF\ChallengeCHBundle\Services;


use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeCHBundle\Entity\Bet;
use ServiceJF\ChallengeCHBundle\Entity\Game;
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
        $bet->setPGap(0);
        $bet->setPPerfect(0);
        $bet->setP1n2(0);
        $player = $bet->getPlayer();
        if ($bet->getResult() == $game->getResult()) {
            $bet->setPoints($this->container->getParameter('ch_points_1n2'));
            $bet->setP1n2($this->container->getParameter('ch_points_1n2'));
            $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_1n2'));
        }
        if ($bet->getBetHome() == $game->getScoreHome() && $bet->getBetAway() == $game->getScoreAway()) {
            $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_perfect'));
            $bet->setPoints($bet->getPoints() + $this->container->getParameter('ch_points_perfect'));
            $bet->setPPerfect($this->container->getParameter('ch_points_perfect'));
            $player->setPerfects($player->getPerfects() + 1);
        }
        if ($game->getGamePhase()->getEliminatory() && $bet->getWinner() == $game->getWinner()) {
            $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_koWinner'));
            $bet->setPoints($bet->getPoints() + $this->container->getParameter('ch_points_koWinner'));
            $bet->setP1n2($this->container->getParameter('ch_points_koWinner'));
        }
        $gap = abs($game->getGap() - $bet->getGap());
        switch ($gap) {
            case 0:
            case 1:
                $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_1gap'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('ch_points_1gap'));
                $bet->setPGap($this->container->getParameter('ch_points_1gap'));
                break;
            case 2:
            case 3:
                $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_3gap'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('ch_points_3gap'));
                $bet->setPGap($this->container->getParameter('ch_points_3gap'));
                break;
            case 4:
            case 5:
                $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_5gap'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('ch_points_5gap'));
                $bet->setPGap($this->container->getParameter('ch_points_5gap'));
                break;
            default:
                $bet->setPGap(0);
        }
        if ($game->getGamePhase()->getFinal()) {
            if ($game->getWinner() == 'home') {
                $finalWinner = $game->getTeamHome();
            } else {
                $finalWinner = $game->getTeamAway();
            }
            if ($finalWinner == $player->getFinalWinner()) {
                $player->setPoints($player->getPoints() + $this->container->getParameter('ch_points_finalWinner'));
                $bet->setPoints($bet->getPoints() + $this->container->getParameter('ch_points_finalWinner'));
            }
        }
        $this->em->persist($bet);
        $this->em->flush();
    }
}