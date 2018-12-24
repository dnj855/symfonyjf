<?php
/**
 * User: cedriclangroth
 * Date: 15/12/2018
 * Time: 11:31
 */

namespace ServiceJF\MiettesBundle\Controller;


use ServiceJF\MiettesBundle\Entity\Volunteer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CleanupController extends Controller
{
    public function randomAction($attempt)
    {
        $cleaner = $this->getDoctrine()->getRepository('ServiceJF\MiettesBundle\Entity\Volunteer')
            ->getDraw($attempt);
        if (empty($cleaner)) {
            return $this->render('ServiceJFMiettesBundle:Cleanup:end.html.twig');
        }
        return $this->render('ServiceJFMiettesBundle:Cleanup:random.html.twig', array(
            'cleaner' => $cleaner[0],
            'attempt' => $attempt
        ));
    }

    public function waitingAction()
    {
        return $this->render('ServiceJFMiettesBundle:Cleanup:waiting.html.twig');
    }

    public function okAction(Volunteer $volunteer)
    {
        $volunteer->setRealCleanups($volunteer->getRealCleanups() + 1);
        $volunteer->setVirtualCleanups($volunteer->getVirtualCleanups() + 1);
        $volunteer->setLastCleanup(new \DateTime());
        $this->getDoctrine()->getManager()->flush();
        return $this->render('ServiceJFMiettesBundle:Cleanup:ok.html.twig', array(
            'volunteer' => $volunteer
        ));
    }
}