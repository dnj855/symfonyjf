<?php
/**
 * User: cedriclangroth
 * Date: 26/11/2017
 * Time: 17:20
 */

namespace ServiceJF\AdminBundle\Controller;


use Mailjet\MailjetSwiftMailer\SwiftMailer\MailjetTransport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    public function indexAction()
    {
        $userRepository = $this->getDoctrine()->getRepository('ServiceJF\UserBundle\Entity\User');
        $enabledUsers = $userRepository->findEnabledUsersByService();
        $disabledUsers = $userRepository->findDisabledUsersByService();

        return $this->render('ServiceJFAdminBundle:admin:index.html.twig', array(
            'enabledUsers' => $enabledUsers,
            'disabledUsers' => $disabledUsers
        ));
    }

    public function navAction() {
        $seasonRepository = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season');
        $seasons = $seasonRepository->findAll();
        $waitingBets = $this->getDoctrine()->getRepository('ServiceJF\ChallengeDLBundle\Entity\GamePhase')->getNonCuratedBets();
        return $this->render('ServiceJFAdminBundle::body_nav.html.twig', array(
            'seasons' => $seasons,
            'waitingBets' => $waitingBets
        ));
    }

}