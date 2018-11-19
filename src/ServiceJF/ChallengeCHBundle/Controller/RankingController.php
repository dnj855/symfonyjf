<?php
/**
 * User: cedriclangroth
 * Date: 15/11/2018
 * Time: 08:43
 */

namespace ServiceJF\ChallengeCHBundle\Controller;


use ServiceJF\ChallengeCHBundle\Entity\Game;
use ServiceJF\ChallengeCHBundle\Entity\Player;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RankingController extends Controller
{
    public function generalAction()
    {
        $playerRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Player');
        $player = $playerRepository->findOneBy(
            array(
                'user' => $this->getUser()
            )
        );
        if ($player != null) {
            $registeredPlayer = true;
        } else {
            $registeredPlayer = false;
        }
        $competitionBegin = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Game')
            ->getCompetitionBegin();
        if (!$competitionBegin instanceof Game) {
            $begin = false;
        } else {
            $begin = true;
        }
        $players = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Player')
            ->findByRanking();
        return $this->render('ServiceJFChallengeCHBundle:Ranking:general.html.twig', array(
            'registeredPlayer' => $registeredPlayer,
            'players' => $players,
            'begin' => $begin
        ));
    }

    public function detailAction(Player $player)
    {
        $playerRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Player');
        $registeredPlayer = $playerRepository->findOneBy(
            array(
                'user' => $this->getUser()
            )
        );
        if ($registeredPlayer != null) {
            $registeredPlayer = true;
        } else {
            $registeredPlayer = false;
        }
        $competitionBegin = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Game')
            ->getCompetitionBegin();
        if (!$competitionBegin instanceof Game) {
            return $this->redirectToRoute('servicejf_challengech_generalRanking');
        }
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Game')
            ->findPlayedGames();
        return $this->render('ServiceJFChallengeCHBundle:Ranking:detail.html.twig', array(
            'registeredPlayer' => $registeredPlayer,
            'player' => $player,
            'games' => $games
        ));
    }

    public function betDetailAction($game, $player)
    {
        $bet = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Bet')
            ->findOneBy(array(
                'game' => $game,
                'player' => $player
            ));
        return $this->render('ServiceJFChallengeCHBundle:Ranking:betDetail.html.twig', array(
            'bet' => $bet
        ));
    }
}