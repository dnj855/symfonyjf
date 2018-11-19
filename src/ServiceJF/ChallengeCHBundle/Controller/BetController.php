<?php
/**
 * User: cedriclangroth
 * Date: 15/11/2018
 * Time: 09:18
 */

namespace ServiceJF\ChallengeCHBundle\Controller;


use ServiceJF\ChallengeCHBundle\Entity\Bet;
use ServiceJF\ChallengeCHBundle\Entity\Game;
use ServiceJF\ChallengeCHBundle\Entity\Player;
use ServiceJF\ChallengeCHBundle\Form\BetType;
use ServiceJF\ChallengeCHBundle\Form\PoolBetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BetController extends Controller
{
    public function poolGameAction(Game $game, Player $player, Request $request)
    {
        $betRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Bet');
        $bet = $betRepository->findOneBy(array(
            'game' => $game,
            'player' => $player
        ));
        if (!$bet instanceof Bet) { //Check if a bet was already registered or not.
            $bet = new Bet($game, $player);
        }
        if (new \DateTime() < $game->getDate()) { //Check if we are still before the game begin.
            $form = $this->createForm(PoolBetType::class, $bet, array(
                'action' => $this->generateUrl('servicejf_challengech_setPoolBet', array(
                    'game' => $game->getId(),
                    'player' => $player->getId()
                ))
            ));
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if ($bet->getBetHome() == $bet->getBetAway()) {
                    $bet->setWinner('draw');
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($bet);
                $em->flush();
                $request->getSession()->getFlashBag()->add('success', 'Pronostic bien enregistré.');
                return $this->redirect($request->headers->get('referer'));
            }
            return $this->render('ServiceJFChallengeCHBundle:Bet:poolBet.html.twig', array(
                'game' => $game,
                'form' => $form->createView()
            ));
        } else {
            if ($request->getMethod() == 'POST') {
                return $this->redirect($request->headers->get('referer'));
            }
            return $this->render('ServiceJFChallengeCHBundle:Game:poolGame.html.twig', array(
                'game' => $game,
                'bet' => $bet,
                'now' => new \DateTime()
            ));
        }
    }

    public function knockoutGameAction(Game $game, Player $player, Request $request)
    {
        $betRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Bet');
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
                return $this->render('ServiceJFChallengeCHBundle:Game:knockoutGame.html.twig', array(
                    'game' => $game,
                    'player' => $player,
                    'bet' => $bet
                ));
            }
            return $this->render('ServiceJFChallengeCHBundle:Game:knockoutGame.html.twig', array(
                'game' => $game,
                'player' => $player
            ));
        } else {
            $form = $this->createForm(BetType::class, $bet, array(
                'action' => $this->generateUrl('servicejf_challengech_setKnockoutBet', array(
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
            return $this->render('ServiceJFChallengeCHBundle:Bet:knockoutBet.html.twig', array(
                'game' => $game,
                'form' => $form->createView(),
                'ko' => true
            ));
        }
    }
}