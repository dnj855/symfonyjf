<?php
/**
 * User: cedriclangroth
 * Date: 04/11/2018
 * Time: 20:57
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\ChallengeCHBundle\Entity\Game;
use ServiceJF\ChallengeCHBundle\Form\GameCreateType;
use ServiceJF\ChallengeCHBundle\Form\GameKoEditType;
use ServiceJF\ChallengeCHBundle\Form\GamePoolEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ChController extends Controller
{
    public function setGameAction(Request $request)
    {
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Game')->findAll();
        $game = new Game();
        $form = $this->createForm(GameCreateType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            return $this->redirectToRoute('servicejf_admin_ch_setGame');
        }
        return $this->render('ServiceJFAdminBundle:Ch:setGame.html.twig', array(
            'games' => $games,
            'form' => $form->createView()
        ));
    }

    public function editGamesAction()
    {
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Game')
            ->findNonFilledGames();
        return $this->render('ServiceJFAdminBundle:Ch:editGames.html.twig', array(
            'games' => $games
        ));
    }

    public function editGameAction(Game $game, Request $request)
    {
        if (new \DateTime() < $game->getDate() || $game->getWinner() != null) {
            $request->getSession()->getFlashBag()->add('warning', 'Ce match ne peut pas être édité.');
            return $this->redirectToRoute('servicejf_admin_ch_editGames');
        }
        $eliminatory = $game->getGamePhase()->getEliminatory();
        if ($eliminatory) {
            $form = $this->createForm(GameKoEditType::class, $game);
        } else {
            $form = $this->createForm(GamePoolEditType::class, $game);
        }
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            if (!$eliminatory && $game->getScoreHome() == $game->getScoreAway()) {
                $game->setWinner('draw');
            }
            $this->getDoctrine()->getManager()->flush();
            $bets = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Bet')
                ->findBy(array(
                    'game' => $game
                ));
            foreach ($bets as $bet) {
                $this->get('servicejf_challengech.betCalculator')->calculate($bet, $game);
            }
            return $this->redirectToRoute('servicejf_admin_ch_editGames');
        }
        return $this->render('ServiceJFAdminBundle:Ch:editGame.html.twig', array(
            'game' => $game,
            'form' => $form->createView()
        ));
    }
}