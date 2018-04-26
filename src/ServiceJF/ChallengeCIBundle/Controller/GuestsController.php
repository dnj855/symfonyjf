<?php
/**
 * User: cedriclangroth
 * Date: 26/12/2017
 * Time: 15:25
 */

namespace ServiceJF\ChallengeCIBundle\Controller;


use ServiceJF\ChallengeCIBundle\Entity\Guest;
use ServiceJF\ChallengeCIBundle\Form\GuestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class GuestsController extends Controller
{

    public function allAction(Request $request)
    {
        if ($request->getSession()->get('ciSeason')) {
            $season = $request->getSession()->get('ciSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $gRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCIBundle\Entity\Guest');
        return $this->render('ServiceJFChallengeCIBundle:guests:all.html.twig', array(
            'guests' => $gRepository->findBySeason($season),
            'season' => $season
        ));
    }

    /**
     * @Security("has_role('ROLE_CI')")
     */
    public function newAction(Request $request)
    {
        $guest = new Guest();
        if ($request->isMethod('GET')) {
            $guest->setHost($this->getUser());
            $guest->setSetter($this->getUser());
        }
        $form = $this->createForm(GuestType::class, $guest);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate($guest->getDate());
            $guest->setSeason($season);
            $em = $this->getDoctrine()->getManager();
            $em->persist($guest);
            $em->flush();
            $this->get('servicejf_challengeci.update_points')->updateHost($guest->getHost(), $season);
            $this->get('servicejf_challengeci.update_points')->updateSetter($guest->getSetter(), $season);
            $request->getSession()->getFlashBag()->add('success', 'L\'invité a bien été enregistré.');
            return $this->redirectToRoute('servicejf_challengeci_homepage');
        }
        return $this->render('ServiceJFChallengeCIBundle:guests:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

}