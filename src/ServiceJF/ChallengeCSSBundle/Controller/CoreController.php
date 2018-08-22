<?php
/**
 * User: cedriclangroth
 * Date: 04/06/2018
 * Time: 20:04
 */

namespace ServiceJF\ChallengeCSSBundle\Controller;


use ServiceJF\ChallengeCSSBundle\Entity\Game;
use ServiceJF\ChallengeCSSBundle\Entity\Player;
use ServiceJF\ChallengeCSSBundle\Form\GameEditType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function chooseSeasonAction(Request $request)
    {
        $form = $this->createFormBuilder(null, array(
            'action' => $this->generateUrl('servicejf_challengecss_seasonChange')
        ))
            ->add('season', EntityType::class, array(
                'class' => 'ServiceJFCoreBundle:Season',
                'choice_label' => function ($season) {
                    return $season->getDateBegin()->format('Y') . '-' . $season->getDateEnd()->format('Y');
                },
                'expanded' => true,
                'label' => false,
                'placeholder' => false,
                'required' => false
            ))
            ->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $request->getSession()->set('cssSeason', $data['season']);
            }
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        return $this->render('ServiceJFChallengeCSSBundle:season:choose.html.twig', array(
            'formSeason' => $form->createView()
        ));
    }

    public function gamesAction(Request $request)
    {
        if ($request->getSession()->get('cssSeason')) {
            $season = $request->getSession()->get('cssSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $gamesRepository = $this->getDoctrine()
            ->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Game');
        $filledGames = $gamesRepository->findFilledGames($season);
        $toBeFilledGames = $gamesRepository->findToBeFilledGames($season);
        return $this->render('ServiceJFChallengeCSSBundle:games:all.html.twig', array(
            'filledGames' => $filledGames,
            'toBeFilledGames' => $toBeFilledGames,
            'season' => $season
        ));
    }

    public function gameEditAction(Game $game, Request $request)
    {
        $form = $this->createForm(GameEditType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            $player = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Player')
                ->findOneBy(array(
                    'user' => $game->getDirector(),
                    'season' => $game->getSeason()
                ));
            if (!$player instanceof Player) {
                $player = new Player($game->getDirector(), $game->getSeason());
            }
            if ($game->getResult() == 'win') {
                $player->setWonGames($player->getWonGames() + 1);
            } elseif ($game->getResult() == 'loss') {
                $player->setLostGames($player->getLostGames() + 1);
            } else {
                $player->setDrawGames($player->getDrawGames() + 1);
            }
            $player->setDirectedGames($player->getDirectedGames() + 1);
            $player->setGoalsFor($player->getGoalsFor() + $game->getScoreFCMetz());
            $player->setGoalsAgainst($player->getGoalsAgainst() + $game->getScoreOpponent());
            $player->setPoints(($player->getWonGames() / $player->getDirectedGames()) * 100);
            $em->persist($player);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La rencontre a bien été enregistrée.');
            return $this->redirectToRoute('servicejf_challengecss_games');
        }
        return $this->render('ServiceJFChallengeCSSBundle:games:edit.html.twig', array(
            'form' => $form->createView(),
            'game' => $game
        ));
    }

    public function generalRankingAction(Request $request)
    {
        if ($request->getSession()->get('cssSeason')) {
            $season = $request->getSession()->get('cssSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $ranking = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Player')
            ->getGeneralRanking($season);
        return $this->render('ServiceJFChallengeCSSBundle:rankings:general.html.twig', array(
            'season' => $season,
            'ranking' => $ranking
        ));
    }

    public function pointsRankingAction(Request $request)
    {
        if ($request->getSession()->get('cssSeason')) {
            $season = $request->getSession()->get('cssSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $ranking = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Player')
            ->getPointsRanking($season);
        return $this->render('ServiceJFChallengeCSSBundle:rankings:points.html.twig', array(
            'season' => $season,
            'ranking' => $ranking
        ));
    }

    public function goalAverageRankingAction(Request $request)
    {
        if ($request->getSession()->get('cssSeason')) {
            $season = $request->getSession()->get('cssSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $ranking = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Player')
            ->getGoalAverageRanking($season);
        return $this->render('ServiceJFChallengeCSSBundle:rankings:goalAverage.html.twig', array(
            'season' => $season,
            'ranking' => $ranking
        ));
    }

    public function detailRankingAction(Player $player)
    {
        $rankingRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Player');
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Game')
            ->findByPlayer($player, $player->getSeason());
        return $this->render('ServiceJFChallengeCSSBundle:rankings:details.html.twig', array(
            'player' => $player,
            'games' => $games
        ));
    }
}