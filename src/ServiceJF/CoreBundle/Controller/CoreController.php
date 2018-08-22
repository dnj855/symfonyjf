<?php
/**
 * User: cedriclangroth
 * Date: 25/11/2017
 * Time: 12:37
 */

namespace ServiceJF\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Stopwatch\Stopwatch;

class CoreController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_CM18_GUEST')) {
            return $this->redirectToRoute('servicejf_cm18_homepage');
        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_JEUDI_GUEST')) {
            return $this->redirectToRoute('servicejf_jeudi_homepage');
        }
        $dlGamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
        $dlFrontEnd = $this->get('servicejf_challengedl.frontEnd')
            ->getHomeAndNavigation($dlGamePhase, $this->getParameter('dl_countdown'));
        return $this->render('ServiceJFCoreBundle::index.html.twig', array(
            'date' => New \DateTime(),
            'dlFrontEnd' => $dlFrontEnd
        ));
    }

    public function navigationAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->getDoctrine()->getManager()->clear();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $waitingBets = $this->getDoctrine()->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase')->getNonCuratedBets();
        } else {
            $waitingBets = "";
        }
        $dlGamePhase = $this->get('servicejf_challengedl.gamePhase')->getGamePhase($this->getUser());
        $dlFrontEnd = $this->get('servicejf_challengedl.frontEnd')
            ->getHomeAndNavigation($dlGamePhase, $this->getParameter('dl_countdown'));
        $parameters['curateBets'] = $waitingBets;
        $parameters['dlFrontEnd'] = $dlFrontEnd;
        return $this->render('::navigation.html.twig', $parameters);
    }

    public function fgRedirectAction()
    {
        return $this->redirectToRoute('servicejf_challengefg_homepage');
    }

    public function ciRedirectAction()
    {
        return $this->redirectToRoute('servicejf_challengeci_homepage');
    }

    public function dlRedirectAction()
    {
        return $this->redirectToRoute('servicejf_challengedl_homepage');
    }
}