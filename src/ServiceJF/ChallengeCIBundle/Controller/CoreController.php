<?php
/**
 * User: cedriclangroth
 * Date: 27/12/2017
 * Time: 18:20
 */

namespace ServiceJF\ChallengeCIBundle\Controller;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function chooseSeasonAction(Request $request)
    {
        $form = $this->createFormBuilder(null, array(
            'action' => $this->generateUrl('servicejf_challengeci_seasonChange')
        ))
            ->add('season', EntityType::class, array(
                'class' => 'ServiceJFCoreBundle:Season',
                'choice_label' => function ($season) {
                    return $season->getDateBegin()->format('Y') . '-' . $season->getDateEnd()->format('Y');
                },
                'expanded' => true,
                'label' => false
            ))
            ->getForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $request->getSession()->set('ciSeason', $data['season']);
            }
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        return $this->render('ServiceJFChallengeCIBundle:season:choose.html.twig', array(
            'form' => $form->createView()
        ));
    }
}