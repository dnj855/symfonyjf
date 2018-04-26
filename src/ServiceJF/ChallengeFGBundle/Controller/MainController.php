<?php

namespace ServiceJF\ChallengeFGBundle\Controller;

use ServiceJF\ChallengeFGBundle\Entity\BestPunchline;
use ServiceJF\ChallengeFGBundle\Entity\Punchline;
use ServiceJF\ChallengeFGBundle\Entity\Vote;
use ServiceJF\ChallengeFGBundle\Form\PunchlineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MainController extends Controller
{

    public function indexAction($year, $month)
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d', $year . '-' . $month . '-15');
        $previous_month = $date->modify('-1 month');
        $next_month = $date->modify('+1 month');
        $now = new \DateTimeImmutable('last day of this month');
        if ($next_month > $now) {
            $next_month = false;
        }
        $punchlinesRepository = $this->getDoctrine()
            ->getRepository('ServiceJF\ChallengeFGBundle\Entity\Punchline');
        $punchlines = $punchlinesRepository->getFromDate($date);
        $votesRepository = $this->getDoctrine()
            ->getRepository('ServiceJF\ChallengeFGBundle\Entity\Vote');
        $votes = $votesRepository->getRemainingVotes($this->getUser());
        if (!$next_month && $votes > 0) {
            $votes_allowed = true;
        } else {
            $votes_allowed = false;
        }
        return $this->render('ServiceJFChallengeFGBundle:punchlines:read.html.twig', array(
            'punchlines' => $punchlines,
            'date' => $date,
            'previousMonth' => $previous_month,
            'nextMonth' => $next_month,
            'votes' => $votes,
            'votesAllowed' => $votes_allowed
        ));
    }

    public function postAction(Request $request)
    {
        $punchline = new Punchline();
        $form = $this->createForm(PunchlineType::class, $punchline);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $punchline->setPoster($this->getUser());
            $em->persist($punchline);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La punchline a bien été enregistrée.');
            return $this->redirectToRoute('servicejf_challengefg_homepage');
        }
        return $this->render('ServiceJFChallengeFGBundle:punchlines:write.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function voteAction(Punchline $punchline, Request $request)
    {
        $month_begin = new \DateTime("first day of this month");
        $month_end = new \DateTime("last day of this month");
        $remainingVotes = $this->getDoctrine()->getRepository('ServiceJF\ChallengeFGBundle\Entity\Vote')
            ->getRemainingVotes($this->getUser());
        if ($punchline->getPostDate() < $month_begin || $punchline->getPostDate() > $month_end || $remainingVotes <= 0) {
            throw new NotFoundHttpException("Impossible de voter pour cette punchline.");
        }
        $vote = new Vote();
        $em = $this->getDoctrine()->getManager();
        $vote->setPunchline($punchline);
        $vote->setVoter($this->getUser());
        $em->persist($vote);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Ton vote a bien été enregistré.');
        return $this->redirectToRoute('servicejf_challengefg_homepage');
    }

    public function bestAction()
    {
        $now = new \DateTimeImmutable("first day of this month");
        $last_month = $now->sub(new \DateInterval('P1M'));
        $doctrine = $this->getDoctrine();
        $bestPunchlineRepository = $doctrine
            ->getRepository('ServiceJF\ChallengeFGBundle\Entity\BestPunchline');
        $punchlineRepository = $doctrine
            ->getRepository('ServiceJF\ChallengeFGBundle\Entity\Punchline');
        $mostRecentPunchline = $bestPunchlineRepository->findMostRecent();
        if ($mostRecentPunchline == null || $last_month->format('m') > $mostRecentPunchline->getMonth()->format('m')) {
            $punchlines = $punchlineRepository->getFromDate($last_month);
            $totalVotes = 0;
            foreach ($punchlines as $punchline) {
                $votes[count($punchline->getVotes())] = $punchline->getId();
                $totalVotes = $totalVotes + count($punchline->getVotes());
            }
            krsort($votes);
            $votes = array_slice($votes, 0, 1, 1);
            $best = new BestPunchline($last_month, key($votes), $totalVotes);
            $bestPunchline = $punchlineRepository->findOneBy(array(
                'id' => array_sum($votes)
            ));
            $best->setPunchline($bestPunchline);
            $em = $doctrine->getManager();
            $em->persist($best);
            $em->flush();
        }
        $punchlines = $bestPunchlineRepository->findAndOrder();
        return $this->render('ServiceJFChallengeFGBundle:punchlines:best.html.twig', array(
            'punchlines' => $punchlines
        ));
    }
}
