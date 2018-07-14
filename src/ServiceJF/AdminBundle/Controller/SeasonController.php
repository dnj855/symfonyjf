<?php
/**
 * User: cedriclangroth
 * Date: 26/11/2017
 * Time: 23:20
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\CoreBundle\Entity\Season;
use ServiceJF\CoreBundle\Form\SeasonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SeasonController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function createAction(Request $request)
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($season);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Saison bien ajoutée.');
            return $this->redirectToRoute('servicejf_admin_home');
        }
        return $this->render('ServiceJFAdminBundle:season:create.html.twig', array(
            'form' => $form->createView()
        ));
    }
}