<?php

namespace ServiceJF\JeudiBundle\Controller;

use ServiceJF\JeudiBundle\Entity\Apero;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class AppointmentController extends Controller
{
    public function interestedAction(Apero $apero, Session $session)
    {
        $apero->addInterestedUser($this->getUser());
        $this->getDoctrine()->getManager()->flush();
        $session->getFlashBag()->add('success', 'Ton inscription est bien enregistrée.');
        return $this->redirectToRoute('servicejf_jeudi_homepage');
    }
}
