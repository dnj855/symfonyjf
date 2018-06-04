<?php
/**
 * User: cedriclangroth
 * Date: 03/05/2018
 * Time: 14:10
 */

namespace ServiceJF\ChallengeCM18Bundle\Controller;


use FeedIo\Reader\ReadErrorException;
use ServiceJF\ChallengeCM18Bundle\Entity\Game;
use ServiceJF\ChallengeCM18Bundle\Entity\GamePhase;
use ServiceJF\ChallengeCM18Bundle\Entity\Player;
use ServiceJF\ChallengeCM18Bundle\Entity\Pool;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function homepageAction()
    {
        $player = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findOneBy(array(
                'identity' => $this->getUser()
            ));
        $endPoolPhase = new \DateTime($this->getParameter('cm18_endPoolPhase'));
        $worldCupBegin = new \DateTime($this->getParameter('cm18_worldCupBegin'));
        $gamePhase = $this->get('servicejf_challengecm18.knockOutCalculator')->getGamePhase(new \DateTime());
        if (new \DateTime() < $worldCupBegin) {
            if (!$player instanceof Player) {
                return $this->render('ServiceJFChallengeCM18Bundle::register.html.twig', array(
                    'betValue' => $this->getParameter('cm18_betValue')
                ));
            } elseif (new \DateTime() < $endPoolPhase) {
                return $this->redirectToRoute('servicejf_cm18_poolDashboard', array(
                    'pool' => '1'
                ));
            } else {
                return $this->redirectToRoute('servicejf_cm18_knockoutDashboard', array(
                    'gamePhase' => $gamePhase->getId()
                ));
            }
        } else {
            if (!$player instanceof Player) {
                return $this->redirectToRoute('servicejf_cm18_nonRegisteredDashboard');
            } elseif (new \DateTime() < $endPoolPhase) {
                return $this->redirectToRoute('servicejf_cm18_poolDashboard', array(
                    'pool' => '1'
                ));
            } else {
                return $this->redirectToRoute('servicejf_cm18_knockoutDashboard', array(
                    'gamePhase' => $gamePhase->getId()
                ));
            }
        }
    }

    public function navigationAction()
    {
        $gamePhase = $this->get('servicejf_challengecm18.knockOutCalculator')->getGamePhase(new \DateTime());
        return $this->render('ServiceJFChallengeCM18Bundle::body_nav.html.twig', array(
            'knockOutGamePhase' => $gamePhase->getId()
        ));
    }

    public function poolDashboardAction(Pool $pool)
    {
        $player = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findOneBy(array(
                'identity' => $this->getUser()
            ));
        if (!$player instanceof Player) {
            return $this->redirectToRoute('servicejf_cm18_homepage');
        }
        $teams = $this->getDoctrine()
            ->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Team')
            ->findRankingByPool($pool);
        $poolRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Pool');
        $pools = $poolRepository->findBy(array(), array('pool' => 'ASC'));
        $gameRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game');
        $games = $gameRepository->findBy(array(
            'pool' => $pool
        ), array(
            'date' => 'ASC'
        ));
        $prizeMoney = $this->get('servicejf_challengecm18.prizeMoneyCalculator')
            ->getPrizeMoney($this->getParameter('cm18_betValue'));
        return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:pool.html.twig', array(
            'activePool' => $pool,
            'teams' => $teams,
            'pools' => $pools,
            'games' => $games,
            'player' => $player,
            'prizeMoney' => $prizeMoney,
            'dashboard' => true
        ));
    }

    public function knockOutDashboardAction(GamePhase $gamePhase)
    {
        $player = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findOneBy(array(
                'identity' => $this->getUser()
            ));
        if (!$player instanceof Player) {
            return $this->redirectToRoute('servicejf_cm18_homepage');
        }
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findKnockoutGames($gamePhase);
        $koGamePhases = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\GamePhase')
            ->findBy(array(
                'eliminatory' => true
            ));
        $prizeMoney = $this->get('servicejf_challengecm18.prizeMoneyCalculator')
            ->getPrizeMoney($this->getParameter('cm18_betValue'));
        return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:knockOut.html.twig', array(
            'games' => $games,
            'phase' => $gamePhase,
            'gamePhases' => $koGamePhases,
            'dashboard' => true,
            'prizeMoney' => $prizeMoney,
            'player' => $player
        ));
    }

    public function newsFeedAction()
    {
        $feedIo = $this->get('feedio');
        $modifiedSince = new \DateTime('2 days ago');
        $url = 'http://fr.fifa.com/worldcup/russia2018/news/rss.xml';
        try {
            $feed = $feedIo->readSince($url, $modifiedSince)->getFeed();
        } catch (ReadErrorException $e) {
            return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:feed.html.twig', array(
                'exception' => 'Erreur de flux.'
            ));
        }
        return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:feed.html.twig', array(
            'feed' => $feed
        ));
    }

    public function gamesDashboardAction()
    {
        $playedGames = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findPlayedGames();
        $toBePlayedGames = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findToBePlayedGames();
        return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:games.html.twig', array(
            'playedGames' => $playedGames,
            'toBePlayedGames' => $toBePlayedGames,
            'gamesDashboard' => true,
            'now' => new \DateTime()
        ));
    }

    public function rankingAction()
    {
        $competitionBegin = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->getCompetitionBegin();
        if (!$competitionBegin instanceof Game) {
            return $this->render('ServiceJFChallengeCM18Bundle:Ranking:waiting.html.twig', array(
                'register' => false,
                'prizeMoney' => $this->get('servicejf_challengecm18.prizeMoneyCalculator')
                    ->getPrizeMoney($this->getParameter('cm18_betValue'))
            ));
        }
        $players = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findByRanking();
        return $this->render('ServiceJFChallengeCM18Bundle:Ranking:main.html.twig', array(
            'players' => $players,
            'prizeMoney' => $this->get('servicejf_challengecm18.prizeMoneyCalculator')
                ->getPrizeMoney($this->getParameter('cm18_betValue'))
        ));
    }

    public function rankingDetailsAction(Player $player)
    {
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findPlayedGames($player);
        return $this->render('ServiceJFChallengeCM18Bundle:Ranking:details.html.twig', array(
            'player' => $player,
            'games' => $games,
            'now' => new \DateTime()
        ));
    }

    public function betDetailAction($game, $player)
    {
        $bet = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Bet')
            ->findOneBy(array(
                'game' => $game,
                'player' => $player
            ));
        return $this->render('ServiceJFChallengeCM18Bundle:Ranking:betDetail.html.twig', array(
            'bet' => $bet
        ));
    }

    public function unregisteredAction()
    {
        $players = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findByRanking();
        return $this->render('ServiceJFChallengeCM18Bundle:Ranking:main.html.twig', array(
            'players' => $players,
            'unregistered' => true
        ));
    }

    public function faqAction()
    {
        $player = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findOneBy(array(
                'identity' => $this->getUser()
            ));
        $points1n2 = $this->getParameter('cm18_points_1n2');
        $pointsPerfect = $this->getParameter('cm18_points_perfect');
        $pointsFinalWinner = $this->getParameter('cm18_points_finalWinner');
        $pointsKoWinner = $this->getParameter('cm18_points_koWinner');
        $betValue = $this->getParameter('cm18_betValue');
        $worldCupBegin = new \DateTime($this->getParameter('cm18_worldCupBegin'));
        if (!$player instanceof Player) {
            return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:faq.html.twig', array(
                'points1n2' => $points1n2,
                'pointsPerfect' => $pointsPerfect,
                'pointsFinalWinner' => $pointsFinalWinner,
                'pointsKoWinner' => $pointsKoWinner,
                'betValue' => $betValue,
                'worldCupBegin' => $worldCupBegin,
                'unregistered' => true
            ));
        } else {
            return $this->render('ServiceJFChallengeCM18Bundle:Dashboard:faq.html.twig', array(
                'points1n2' => $points1n2,
                'pointsPerfect' => $pointsPerfect,
                'pointsFinalWinner' => $pointsFinalWinner,
                'pointsKoWinner' => $pointsKoWinner,
                'betValue' => $betValue,
                'worldCupBegin' => $worldCupBegin,
            ));
        }
    }
}