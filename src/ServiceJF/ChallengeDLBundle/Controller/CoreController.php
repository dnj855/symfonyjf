<?php
/**
 * User: cedriclangroth
 * Date: 17/03/2018
 * Time: 22:23
 */

namespace ServiceJF\ChallengeDLBundle\Controller;


use Doctrine\DBAL\Exception\ServerException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CoreController extends Controller
{
    public function mainAction()
    {
        $endBet = new \DateTime($this->getParameter('dl_countdown'));
        if (new \DateTime() < $endBet) {
            $gamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
            if ($gamePhase == "newPlayer") {
                return $this->redirectToRoute('servicejf_challengedl_newPlayer');
            } elseif ($gamePhase == "stillBetting") {
                return $this->redirectToRoute('servicejf_challengedl_setBet');
            } elseif ($gamePhase == "validBet") {
                return $this->redirectToRoute('servicejf_challengedl_validBet');
            } elseif ($gamePhase == "curatedBet") {
                return $this->redirectToRoute('servicejf_challengedl_viewBets');
            } else {
                throw new NotFoundHttpException("Cas de figure non prévu.");
            }
        } else {
            return $this->redirectToRoute('servicejf_challengedl_viewBets');
        }
    }

    public function viewAction()
    {
        $endBet = new \DateTime($this->getParameter('dl_countdown'));
        $gamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
        if (new \DateTime() < $endBet && $gamePhase != "curatedBet") {
            return $this->redirectToRoute('servicejf_challengedl_homepage');
        }
        $points = $this->get('servicejf_challengedl.pointsChecker')->checkPoints();
        $doctrine = $this->getDoctrine();
        $ranking = $doctrine->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase')->getRanking();
        $players = $doctrine->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase')->findAll();
        return $this->render('ServiceJFChallengeDLBundle:results:all.html.twig', array(
            'points' => $points,
            'ranking' => $ranking,
            'players' => $players
        ));
    }

    public function faqAction()
    {
        $endBet = new \DateTime($this->getParameter('dl_countdown'));
        return $this->render('ServiceJFChallengeDLBundle::faq.html.twig', array(
            'endBet' => $endBet
        ));
    }
}