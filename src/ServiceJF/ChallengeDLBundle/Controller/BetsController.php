<?php
/**
 * User: cedriclangroth
 * Date: 18/03/2018
 * Time: 10:33
 */

namespace ServiceJF\ChallengeDLBundle\Controller;


use ServiceJF\ChallengeDLBundle\Entity\GamePhase;
use ServiceJF\ChallengeDLBundle\Entity\SetBet;
use ServiceJF\ChallengeDLBundle\Form\SetBetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BetsController extends Controller
{
    public function newAction(Request $request)
    {
        $gamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
        if ($gamePhase != "newPlayer") {
            return $this->redirectToRoute('servicejf_challengedl_homepage');
        }
        $countdown = (new \DateTime())->diff(new \DateTime($this->container->getParameter('dl_countdown')));
        $setBet = new SetBet();
        $form = $this->createForm(SetBetType::class, $setBet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $setBet->setBetter($this->getUser());
            $gamePhase = new GamePhase();
            $gamePhase->setSetBet($setBet);
            $gamePhase->setBetter($this->getUser());
            if ('save' === $form->getClickedButton()->getName()) {
                $gamePhase->setValidBet(true);
                $setBet->setBetDate(new \DateTime());
            }
            $em->persist($setBet);
            $em->persist($gamePhase);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Les paris ont bien été enregistrés.');
            return $this->redirectToRoute('servicejf_challengedl_homepage');
        }
        return $this->render('ServiceJFChallengeDLBundle:bets:newBet.html.twig', array(
            'countdown' => $countdown,
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request)
    {
        $gamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
        if ($gamePhase != "stillBetting") {
            return $this->redirectToRoute('servicejf_challengedl_homepage');
        }
        $countdown = (new \DateTime())->diff(new \DateTime($this->container->getParameter('dl_countdown')));
        $doctrine = $this->getDoctrine();
        $setBet = $doctrine->getRepository('ServiceJF\ChallengeDLBundle\Entity\SetBet')->findOneBy(array(
            'better' => $this->getUser()
        ));
        $form = $this->createForm(SetBetType::class, $setBet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ('save' === $form->getClickedButton()->getName()) {
                $gamePhase = $doctrine->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase')->findOneBy(array(
                    'better' => $this->getUser()
                ));
                $gamePhase->setValidBet(true);
                $setBet->setBetDate(new \DateTime());
            }
            $doctrine->getManager()->flush();
            $request->getSession()->getFlashBag()->add('success', 'Les paris ont bien été enregistrés.');
            return $this->redirectToRoute('servicejf_challengedl_homepage');
        }
        return $this->render('ServiceJFChallengeDLBundle:bets:setBet.html.twig', array(
            'countdown' => $countdown,
            'form' => $form->createView()
        ));
    }

    public function validAction()
    {
        $gamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
        if ($gamePhase != "validBet") {
            return $this->redirectToRoute('servicejf_challengedl_homepage');
        }
        $setBetRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeDLBundle\Entity\SetBet');
        $setBet = $setBetRepository->findOneBy(array(
            'better' => $this->getUser()
        ));
        $validationDate = $setBet->getBetDate();
        $form = $this->createForm(SetBetType::class, $setBet);
        return $this->render('ServiceJFChallengeDLBundle:bets:validBet.html.twig', array(
            'form' => $form->createView(),
            'date' => $validationDate
        ));
    }
}