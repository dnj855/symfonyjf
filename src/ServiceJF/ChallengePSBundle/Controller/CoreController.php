<?php
/**
 * User: cedriclangroth
 * Date: 24/04/2018
 * Time: 22:20
 */

namespace ServiceJF\ChallengePSBundle\Controller;


use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use ServiceJF\ChallengePSBundle\Entity\Bet;
use ServiceJF\ChallengePSBundle\Form\BetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function betsAction(Request $request, $page)
    {
        $bet = new Bet();
        $form = $this->createForm(BetType::class, $bet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bet->setBetter($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($bet);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Ton pari a bien été enregistré.');
            return $this->redirectToRoute('servicejf_challengeps_homepage');
        }
        $bets = $this->getDoctrine()->getRepository('ServiceJF\ChallengePSBundle\Entity\Bet')
            ->findBy(array(
                'enabled' => 1
            ), array(
                'date' => 'desc'
            ));
        $adapter = new ArrayAdapter($bets);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        if ($pager->haveToPaginate()) {
        $pager->setCurrentPage($page);
        $current_bets = $pager->getCurrentPageResults();
            return $this->render('ServiceJFChallengePSBundle:core:bets.html.twig', array(
                'bets' => $current_bets,
                'form' => $form->createView(),
                'my_pager' => $pager
            ));
        } else {
            return $this->render('ServiceJFChallengePSBundle:core:bets.html.twig', array(
                'bets' => $bets,
                'form' => $form->createView()
            ));
        }
    }
}