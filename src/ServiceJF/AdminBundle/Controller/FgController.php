<?php
/**
 * User: cedriclangroth
 * Date: 06/12/2017
 * Time: 22:44
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\ChallengeFGBundle\Entity\BestPunchline;
use ServiceJF\ChallengeFGBundle\Entity\Punchline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FgController extends Controller
{
    public function disableAction(Punchline $punchline, Request $request)
    {
        if ($request->isMethod('POST')) {
            $punchline->disable();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La punchline a bien été desactivée.');
            return $this->redirectToRoute('servicejf_challengefg_homepage');
        }
        return $this->render('ServiceJFAdminBundle:fg:disable.html.twig', array(
            'punchline' => $punchline
        ));
    }

    public function setBestAction(Request $request)
    {
        $now = new \DateTimeImmutable('first day of this month');
        $doctrine = $this->getDoctrine();
        $punchlineRepository = $doctrine->getRepository('ServiceJF\ChallengeFGBundle\Entity\Punchline');
        $bestPunchlineRepository = $doctrine->getRepository('ServiceJF\ChallengeFGBundle\Entity\BestPunchline');
        for($month = $now->sub(new \DateInterval('P1M')); $punchlineRepository->getFromDate($month); $month = $month->sub(new \DateInterval('P1M'))) {
            $totalVotes = 0;
            $votes = array();
            if ($bestPunchlineRepository->findBy(array(
                'month' => $month
            ))) {
                continue;
            }
            $punchlines = $punchlineRepository->getFromDate($month);
            foreach ($punchlines as $punchline) {
                $votes[count($punchline->getVotes())] = $punchline->getId();
                $totalVotes = $totalVotes + count($punchline->getVotes());
            }
            if ($totalVotes == 0) {
                continue;
            }
            krsort($votes);
            $votes = array_slice($votes, 0, 1, 1);
            $best = new BestPunchline($month, key($votes), $totalVotes);
            $bestPunchline = $punchlineRepository->findOneBy(array(
                'id' => array_sum($votes)
            ));
            $best->setPunchline($bestPunchline);
            $em = $doctrine->getManager();
            $em->persist($best);
            $em->flush();
        }
        $request->getSession()->getFlashBag()->add('success', 'Les meilleures punchlines ont été calculées.');
        return $this->redirectToRoute('servicejf_admin_home');
    }
}