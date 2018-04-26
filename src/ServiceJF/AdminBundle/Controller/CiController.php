<?php
/**
 * User: cedriclangroth
 * Date: 30/12/2017
 * Time: 19:40
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\ChallengeCIBundle\Entity\Guest;
use ServiceJF\ChallengeCIBundle\Form\GuestType;
use ServiceJF\CoreBundle\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CiController extends Controller
{

    public function modifyAction(Guest $guest)
    {
        $form = $this->createForm(GuestType::class, $guest);
        return $this->render('ServiceJFAdminBundle:ci:modify.html.twig', array(
            'form' => $form->createView(),
            'guest' => $guest
        ));
    }

    public function pointsAction(Season $season, Request $request)
    {
        $guestRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCIBundle\Entity\Guest');
        $hosts = $guestRepository->getAllHosts($season);
        $userRepository = $this->getDoctrine()->getRepository('ServiceJF\UserBundle\Entity\User');
        $updatePoints = $this->get('servicejf_challengeci.update_points');
        foreach ($hosts as $host) {
            $user = $userRepository->findOneBy(array(
                'id' => $host['id']
            ));
            $updatePoints->updateHost($user, $season);
            $updatePoints->updateSetter($user, $season);
        }
        $request->getSession()->getFlashBag()->add('success', 'Les points ont été mis à jour !');
        return $this->redirectToRoute('servicejf_admin_home');
    }
}