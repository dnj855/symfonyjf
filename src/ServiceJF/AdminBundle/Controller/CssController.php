<?php
/**
 * User: cedriclangroth
 * Date: 04/06/2018
 * Time: 08:45
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\ChallengeCSSBundle\Entity\Game;
use ServiceJF\ChallengeCSSBundle\Entity\Team;
use ServiceJF\ChallengeCSSBundle\Form\GameCreateType;
use ServiceJF\ChallengeCSSBundle\Form\GameEditDateType;
use ServiceJF\ChallengeCSSBundle\Form\TeamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CssController extends Controller
{
    public function teamsAction(Request $request)
    {
        $team = new Team();
        $teams = $this->getDoctrine()
            ->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Team')->findBy(array(), array(
                'name' => 'ASC'
            ));
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success", "L'équipe a bien été ajoutée.");
            return $this->redirectToRoute('servicejf_admin_css_teams');
        }
        return $this->render('ServiceJFAdminBundle:css:teams.html.twig', array(
            'form' => $form->createView(),
            'teams' => $teams
        ));
    }

    public function teamAction(Team $team, Request $request)
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            $request->getSession()->getFlashBag()->add("success", $team->getName() . " a bien été modifié.");
            return $this->redirectToRoute('servicejf_admin_css_teams');
        }
        return $this->render('ServiceJFAdminBundle:css:teamEdit.html.twig', array(
            'form' => $form->createView(),
            'team' => $team
        ));
    }

    public function teamEnableAction(Team $team, Request $request)
    {
        $team->setEnabled(true);
        $this->getDoctrine()->getManager()->flush();
        $request->getSession()->getFlashBag()->add("success", $team->getName() . " a bien été activé.");
        return $this->redirectToRoute('servicejf_admin_css_teams');
    }

    public function teamDisableAction(Team $team, Request $request)
    {
        $team->setEnabled(false);
        $this->getDoctrine()->getManager()->flush();
        $request->getSession()->getFlashBag()->add("success", $team->getName() . " a bien été desactivé.");
        return $this->redirectToRoute('servicejf_admin_css_teams');
    }

    public function gamesAction(Request $request)
    {
        if ($request->getSession()->get('cssSeason')) {
            $season = $request->getSession()->get('cssSeason');
        } else {
            $season = $this->getDoctrine()->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate(new \DateTime());
        }
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCSSBundle\Entity\Game')
            ->findBy(array(
                'season' => $season
            ), array(
                'date' => 'ASC'
            ));
        return $this->render('ServiceJFAdminBundle:css:games.html.twig', array(
            'games' => $games,
            'season' => $season
        ));
    }

    public function gameCreateAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameCreateType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game->setSeason($this->getDoctrine()
                ->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate($game->getDate()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le match a bien été créé.');
            return $this->redirectToRoute('servicejf_admin_css_games');
        }
        return $this->render('ServiceJFAdminBundle:css:gameCreate.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function gameEditAction(Game $game, Request $request)
    {
        $form = $this->createForm(GameEditDateType::class, $game, array(
            'action' => $this->generateUrl('servicejf_admin_css_gameEdit', array(
                'game' => $game->getId()
            ))
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game->setSeason($this->getDoctrine()
                ->getRepository('ServiceJF\CoreBundle\Entity\Season')
                ->findByDate($game->getDate()));
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le match a bien été modifié.');
            return $this->redirectToRoute('servicejf_admin_css_games');
        }
        return $this->render('ServiceJFAdminBundle:css:gameEdit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}