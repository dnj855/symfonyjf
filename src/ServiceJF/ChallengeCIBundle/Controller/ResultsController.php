<?php
/**
 * User: cedriclangroth
 * Date: 25/12/2017
 * Time: 19:11
 */

namespace ServiceJF\ChallengeCIBundle\Controller;


use ServiceJF\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ResultsController extends Controller
{
    public function generalAction(Request $request)
    {
        if ($request->getSession()->get('ciSeason')) {
            $season = $request->getSession()->get('ciSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $pointsRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCIBundle\Entity\Points');
        $ranking = $pointsRepository->getGeneralRanking($season);
        $guestsRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCIBundle\Entity\Guest');
        $lastGuest = $guestsRepository->getLastGuest($season);
        return $this->render('ServiceJFChallengeCIBundle:results:general.html.twig', array(
            'season' => $season,
            'ranking' => $ranking,
            'lastGuest' => $lastGuest
        ));
    }

    public function userAction(User $user, Request $request)
    {
        if ($request->getSession()->get('ciSeason')) {
            $season = $request->getSession()->get('ciSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $pointsRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCIBundle\Entity\Points');
        $guestRepository = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCIBundle\Entity\Guest');
        $points = $pointsRepository->findByUserAndSeason($user, $season);
        $setGuests = $guestRepository->findBySetter($user, $season);
        $hostGuests = $guestRepository->findByHost($user, $season);
        if (!$points) {
            $request->getSession()->getFlashBag()->add('warning', 'Impossible d\'afficher les résultats de ' . $user->getSurname() . ' ' . $user->getName() . '.');
            return $this->redirectToRoute('servicejf_challengeci_homepage');
        } else {
            return $this->render('ServiceJFChallengeCIBundle:results:user.html.twig', array(
                'points' => $points,
                'season' => $season,
                'setGuests' => $setGuests,
                'hostGuests' => $hostGuests
            ));
        }
    }
}