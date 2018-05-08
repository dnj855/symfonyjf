<?php
/**
 * User: cedriclangroth
 * Date: 22/03/2018
 * Time: 16:52
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\AdminBundle\Form\curateBetType;
use ServiceJF\AdminBundle\Form\managePersonalityType;
use ServiceJF\ChallengeDLBundle\Entity\Personality;
use ServiceJF\ChallengeDLBundle\Entity\SetBet;
use ServiceJF\ChallengeDLBundle\Entity\ValidBet;
use ServiceJF\ChallengeDLBundle\Form\CreatePersonalityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DlController extends Controller
{
    public function curationAction()
    {
        $doctrine = $this->getDoctrine();
        $gamePhaseRepository = $doctrine->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase');
        $nonCuratedBets = $gamePhaseRepository->getNonCuratedBets();
        $personalityRepository = $doctrine->getRepository('ServiceJF\ChallengeDLBundle\Entity\Personality');
        $personalities = $personalityRepository->findBy(array(), array(
            'name' => 'ASC'
        ));
        return $this->render('ServiceJFAdminBundle:dl:curation.html.twig', array(
            'bets' => $nonCuratedBets,
            'personalities' => $personalities
        ));
    }

    public function curateAction(SetBet $setBet, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(curateBetType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $setJoker = $setBet->getJoker();
            $data = $form->getData();
            $index = 1;
            $gamePhaseRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase');
            $gamePhase = $gamePhaseRepository->findOneBy(array(
                'better' => $setBet->getBetter()
            ));
            foreach ($data as $bet) {
                $validBet = new ValidBet($gamePhase);
                if ($setJoker == $index) {
                    $validBet->setJoker(true);
                } else {
                    $validBet->setJoker(false);
                }
                $validBet->setPersonality($bet);
                $em->persist($validBet);
                $em->flush();
                $index++;
            }
            $gamePhase = $this->getDoctrine()
                ->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase')
                ->findOneBy(array(
                    'better' => $setBet->getBetter()
                ));
            $gamePhase->setCuratedBet(true);
            $em->flush($gamePhase);
            $this->get('servicejf.mailer')->sendDlSetBetMail($gamePhase);
            $this->addFlash('success', 'Les paris ont été enregistrés.');
            return $this->redirectToRoute('servicejf_admin_dl_curateBets');
        }
        return $this->render('ServiceJFAdminBundle:dl:curate.html.twig', array(
            'setBet' => $setBet,
            'form' => $form->createView()
        ));
    }

    public function newPersonalityAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $personality = new Personality();
        $form = $this->createForm(CreatePersonalityType::class, $personality);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personality->setDead(false);
            $em->persist($personality);
            $em->flush();
            return $this->render('ServiceJFAdminBundle:dl:createdPersonality.html.twig');
        }
        return $this->render('ServiceJFAdminBundle:dl:createPersonality.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function managePersonalityAction(Personality $personality, Request $request)
    {
        $form = $this->createForm(managePersonalityType::class, $personality);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personality->setDead(true);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->get('servicejf_challengedl.updatePoints')->updatePoints($personality);
            $request->getSession()->getFlashBag()->add('success', 'Bien reçu, chef !');
            return $this->redirectToRoute('servicejf_admin_dl_curateBets');
        }
        return $this->render('ServiceJFAdminBundle:dl:managePersonality.html.twig', array(
            'personality' => $personality,
            'form' => $form->createView()
        ));
    }
}