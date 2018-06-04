<?php
/**
 * User: cedriclangroth
 * Date: 05/05/2018
 * Time: 22:57
 */

namespace ServiceJF\ChallengeCM18Bundle\Controller;


use ServiceJF\ChallengeCM18Bundle\Entity\Bet;
use ServiceJF\ChallengeCM18Bundle\Entity\Game;
use ServiceJF\ChallengeCM18Bundle\Entity\Player;
use ServiceJF\ChallengeCM18Bundle\Entity\Team;
use ServiceJF\ChallengeCM18Bundle\Form\BetType;
use ServiceJF\ChallengeCM18Bundle\Form\PoolBetType;
use ServiceJF\ChallengeCM18Bundle\Form\FinalWinnerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BetController extends Controller
{
    public function finalWinnerAction(Request $request)
    {
        $player = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findOneBy(array(
                'identity' => $this->getUser()
            ));
        if ($player->getFinalBet() instanceof Team || new \DateTime() > new \DateTime($this->getParameter('cm18_worldCupBegin'))) {
            return new Response('');
        } else {
            $form = $this->createForm(FinalWinnerType::class, $player, array(
                'action' => $this->generateUrl('servicejf_cm18_setFinalWinner')
            ));
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Pronostic enregistré.');
                return $this->redirectToRoute('servicejf_cm18_homepage');
            }
            return $this->render('ServiceJFChallengeCM18Bundle:Bet:finalWinner.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    public function poolGameAction(Game $game, Player $player, Request $request)
    {
        $betRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Bet');
        $bet = $betRepository->findOneBy(array(
            'game' => $game,
            'player' => $player
        ));
        if (!$bet instanceof Bet) { //Check if a bet was already registered or not.
            $bet = new Bet($game, $player);
        }
        if (new \DateTime() < $game->getDate()) { //Check if we are still before the game begin.
            $form = $this->createForm(PoolBetType::class, $bet, array(
                'action' => $this->generateUrl('servicejf_cm18_setPoolBet', array(
                    'game' => $game->getId(),
                    'player' => $player->getId()
                ))
            ));
            $betOdds = $this->get('servicejf_challengecm18.betOdds');
            $betOdds->findBetOdds($game);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if ($bet->getBetHome() > $bet->getBetAway()) {
                    $bet->setResult('home');
                    $bet->setWinner('home');
                } elseif ($bet->getBetHome() == $bet->getBetAway()) {
                    $bet->setResult('draw');
                    $bet->setWinner('draw');
                } else {
                    $bet->setResult('away');
                    $bet->setWinner('away');
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($bet);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Pronostic bien enregistré.');
                return $this->redirect($request->headers->get('referer'));
            }
            return $this->render('ServiceJFChallengeCM18Bundle:Bet:poolBet.html.twig', array(
                'game' => $game,
                'form' => $form->createView(),
                'betOdds' => $betOdds
            ));
        } else {
            if ($request->getMethod() == 'POST') {
                return $this->redirect($request->headers->get('referer'));
            }
            return $this->render('ServiceJFChallengeCM18Bundle:Game:poolGame.html.twig', array(
                'game' => $game,
                'bet' => $bet,
                'now' => new \DateTime()
            ));
        }
    }

    public function knockoutGameAction(Game $game, Player $player, Request $request)
    {
        $betRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Bet');
        $bet = $betRepository->findOneBy(array(
            'game' => $game,
            'player' => $player
        ));
        if (!$bet instanceof Bet) {
            $bet = new Bet($game, $player);
        }
        if ($game->getTeamHome() == NULL || $game->getTeamAway() == NULL || new \DateTime() >= $game->getDate()) {
            if ($request->getMethod() == 'POST') {
                return $this->redirect($request->headers->get('referer'));
            }
            if (new \DateTime() >= $game->getDate()) {
                return $this->render('ServiceJFChallengeCM18Bundle:Game:knockoutGame.html.twig', array(
                    'game' => $game,
                    'player' => $player,
                    'bet' => $bet
                ));
            }
            return $this->render('ServiceJFChallengeCM18Bundle:Game:knockoutGame.html.twig', array(
                'game' => $game,
                'player' => $player
            ));
        } else {
            $betOdds = $this->get('servicejf_challengecm18.betOdds');
            $betOdds->findBetOdds($game);
            $form = $this->createForm(BetType::class, $bet, array(
                'action' => $this->generateUrl('servicejf_cm18_setKnockoutBet', array(
                    'game' => $game->getId(),
                    'player' => $player->getId()
                ))
            ));
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if ($bet->getBetHome() > $bet->getBetAway()) {
                    $bet->setResult('home');
                    $bet->setWinner('home');
                } elseif ($bet->getBetHome() == $bet->getBetAway()) {
                    $bet->setResult('draw');
                } else {
                    $bet->setResult('away');
                    $bet->setWinner('away');
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($bet);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Pronostic bien enregistré.');
                return $this->redirect($request->headers->get('referer'));
            }
            return $this->render('ServiceJFChallengeCM18Bundle:Bet:knockoutBet.html.twig', array(
                'game' => $game,
                'form' => $form->createView(),
                'betOdds' => $betOdds,
                'ko' => true
            ));
        }
    }
}