<?php
/**
 * User: cedriclangroth
 * Date: 02/11/2018
 * Time: 21:48
 */

namespace ServiceJF\ChallengeCHBundle\Controller;


use ServiceJF\ChallengeCHBundle\Entity\Player;
use ServiceJF\ChallengeCHBundle\Form\PlayerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function homePageAction()
    {
        $playerRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Player');
        $player = $playerRepository->findOneBy(
            array(
                'user' => $this->getUser()
            )
        );
        if (!$player && new \DateTime() < new \DateTime($this->getParameter('ch_competitionBegin'))) {
            $registeredPlayer = false;
            return $this->redirectToRoute('servicejf_challengech_finalWinner');
        } elseif (!$player && new \DateTime() >= new \DateTime($this->getParameter('ch_competitionBegin'))) {
            $registeredPlayer = false;
            return $this->redirectToRoute('servicejf_challengech_generalRanking');
        } else {
            $registeredPlayer = true;
        }
        $gameRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Game');
        $games = $gameRepository->findBy(array(), array(
            'date' => 'DESC'
        ));
        return $this->render('ServiceJFChallengeCHBundle:Core:dashboard.html.twig', array(
            'registeredPlayer' => $registeredPlayer,
            'games' => $games,
            'player' => $player
        ));
    }

    public function finalWinnerAction(Request $request)
    {
        $playerRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCHBundle\Entity\Player');
        $player = $playerRepository->findOneBy(
            array(
                'user' => $this->getUser()
            )
        );
        if ($player != null) {
            return $this->redirectToRoute('servicejf_challengech_homePage');
        } else {
            $registeredPlayer = false;
        }
        $player = new Player($this->getUser());
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $player->setPoints(0);
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute('servicejf_challengech_homePage');
        }
        return $this->render('ServiceJFChallengeCHBundle:Core:finalWinner.html.twig', array(
            'registeredPlayer' => $registeredPlayer,
            'form' => $form->createView()
        ));
    }

    public function faqAction()
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
        return $this->render('ServiceJFChallengeCHBundle:Core:faq.html.twig', array(
            'finalWinner' => $this->getParameter('ch_points_finalWinner'),
            'registeredPlayer' => $registeredPlayer,
            'competitionBegin' => $this->getParameter('ch_competitionBegin'),
            'p1n2' => $this->getParameter('ch_points_1n2'),
            'koWinner' => $this->getParameter('ch_points_koWinner'),
            'p1gap' => $this->getParameter('ch_points_1gap'),
            'p3gap' => $this->getParameter('ch_points_3gap'),
            'p5gap' => $this->getParameter('ch_points_5gap'),
            'perfect' => $this->getParameter('ch_points_perfect')
        ));
    }

}