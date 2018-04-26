<?php
/**
 * User: cedriclangroth
 * Date: 24/04/2018
 * Time: 22:58
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\ChallengePSBundle\Entity\Bet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PsController extends Controller
{
    public function adminPanelAction()
    {
        $bets = $this->getDoctrine()->getRepository('ServiceJF\ChallengePSBundle\Entity\Bet')
            ->findBy(array(
                'enabled' => 1
            ), array(
                'date' => 'desc'
            ));
        return $this->render('ServiceJFAdminBundle:ps:adminPanel.html.twig', array(
            'bets' => $bets
        ));
    }

    public function trueBetAction(Bet $bet)
    {
        $bet->setCorrect(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('servicejf_admin_ps');
    }

    public function falseBetAction(Bet $bet)
    {
        $bet->setCorrect(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('servicejf_admin_ps');
    }

    public function disableBetAction(Bet $bet)
    {
        $bet->setEnabled(false);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('servicejf_admin_ps');
    }
}