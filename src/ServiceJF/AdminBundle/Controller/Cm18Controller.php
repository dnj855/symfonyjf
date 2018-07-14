<?php
/**
 * User: cedriclangroth
 * Date: 02/05/2018
 * Time: 19:01
 */

namespace ServiceJF\AdminBundle\Controller;


use ServiceJF\AdminBundle\Form\UserCM18GuestType;
use ServiceJF\ChallengeCM18Bundle\Entity\Game;
use ServiceJF\ChallengeCM18Bundle\Entity\GamePhase;
use ServiceJF\ChallengeCM18Bundle\Entity\Player;
use ServiceJF\ChallengeCM18Bundle\Entity\Pool;
use ServiceJF\ChallengeCM18Bundle\Entity\RankingMail;
use ServiceJF\ChallengeCM18Bundle\Entity\Team;
use ServiceJF\ChallengeCM18Bundle\Form\GameCreateType;
use ServiceJF\ChallengeCM18Bundle\Form\GameKoEditType;
use ServiceJF\ChallengeCM18Bundle\Form\GamePoolEditType;
use ServiceJF\ChallengeCM18Bundle\Form\GamePhaseType;
use ServiceJF\ChallengeCM18Bundle\Form\PoolType;
use ServiceJF\ChallengeCM18Bundle\Form\TeamType;
use ServiceJF\UserBundle\Entity\User;
use ServiceJF\UserBundle\Form\UserCreateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class Cm18Controller extends Controller
{

    public function addPlayersAction(Request $request)
    {
        $players = $this->getDoctrine()->getRepository('ServiceJF\UserBundle\Entity\User')
            ->findBy(array(
                'enabled' => true
            ), array(
                'surname' => 'ASC'
            ));
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $this->createForm(UserCreateType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $player = new Player($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'Le joueur a bien été créé.');
            return $this->redirectToRoute('servicejf_admin_cm18_addPlayers');
        }
        return $this->render('ServiceJFAdminBundle:Cm18:addPlayers.html.twig', array(
            'players' => $players,
            'form' => $form->createView()
        ));
    }

    public function addPlayerAction(User $user, Request $request)
    {
        $playerRepo = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player');
        if ($playerRepo->findOneBy(array(
                'identity' => $user
            )) instanceof Player) {
            $request->getSession()->getFlashBag()->add('warning', 'Ce joueur a déjà été ajouté');
            return $this->redirectToRoute('servicejf_admin_cm18_addPlayers');
        }
        $player = new Player($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', 'Le joueur a bien été ajouté.');
        return $this->redirectToRoute('servicejf_admin_cm18_addPlayers');
    }

    public function editGamesAction()
    {
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findNonFilledGames();
        return $this->render('ServiceJFAdminBundle:Cm18:editGames.html.twig', array(
            'games' => $games
        ));
    }

    public function editGameAction(Game $game, Request $request)
    {
        if (new \DateTime() < $game->getDate() || $game->getWinner() != null) {
            $request->getSession()->getFlashBag()->add('warning', 'Ce match ne peut pas être édité.');
            return $this->redirectToRoute('servicejf_admin_cm18_editGames');
        }
        $eliminatory = $game->getGamePhase()->getEliminatory();
        if ($eliminatory) {
            $form = $this->createForm(GameKoEditType::class, $game);
        } else {
            $form = $this->createForm(GamePoolEditType::class, $game);
        }
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            if (!$eliminatory) {
                if ($game->getScoreHome() == $game->getScoreAway()) {
                    $game->setWinner('draw');
                    $game->getTeamHome()->poolGame('draw', $game->getScoreAway(), $game->getScoreHome());
                    $game->getTeamAway()->poolGame('draw', $game->getScoreAway(), $game->getScoreHome());
                } elseif ($game->getScoreHome() > $game->getScoreAway()) {
                    $game->getTeamHome()->poolGame('win', $game->getScoreHome(), $game->getScoreAway());
                    $game->getTeamAway()->poolGame('loss', $game->getScoreAway(), $game->getScoreHome());
                } else {
                    $game->getTeamAway()->poolGame('win', $game->getScoreAway(), $game->getScoreHome());
                    $game->getTeamHome()->poolGame('loss', $game->getScoreHome(), $game->getScoreAway());
                }
            }
            $this->getDoctrine()->getManager()->flush();
            $bets = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Bet')
                ->findBy(array(
                    'game' => $game
                ));
            foreach ($bets as $bet) {
                $this->get('servicejf_challengecm18.betCalculator')->calculate($bet, $game);
            }
            $gamesCalculator = $this->get('servicejf_challengecm18.gamesCalculator');
            $gamesCalculator->calculateGame($game);
            return $this->redirectToRoute('servicejf_admin_cm18_editGames');
        }
        return $this->render('ServiceJFAdminBundle:Cm18:editGame.html.twig', array(
            'game' => $game,
            'form' => $form->createView()
        ));
    }

    public function correctAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $teams = $doctrine->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Team')
            ->findAll();
        $games = $doctrine->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findAll();
        $players = $doctrine->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findAll();
        foreach ($teams as $team) {
            $team->setPoints(0);
            $team->setDraw(0);
            $team->setGoalAverage(0);
            $team->setGoalsAgainst(0);
            $team->setGoalsFor(0);
            $team->setLost(0);
            $team->setPlayedGames(0);
            $team->setWon(0);
            $em->persist($team);
            $em->flush();
        }
        foreach ($games as $game) {
            if ($game->getWinner() != null) {
                $teamHome = $game->getTeamHome();
                $teamAway = $game->getTeamAway();
                if (!$game->getGamePhase()->getEliminatory()) {
                    if ($game->getResult() == 'home') {
                        $teamHome->poolGame('win', $game->getScoreHome(), $game->getScoreAway());
                        $teamAway->poolGame('loss', $game->getScoreAway(), $game->getScoreHome());
                    } elseif ($game->getResult() == 'away') {
                        $teamHome->poolGame('loss', $game->getScoreHome(), $game->getScoreAway());
                        $teamAway->poolGame('win', $game->getScoreAway(), $game->getScoreHome());
                    } else {
                        $teamHome->poolGame('draw', $game->getScoreHome(), $game->getScoreAway());
                        $teamAway->poolGame('draw', $game->getScoreAway(), $game->getScoreHome());
                    }
                    $em->persist($game);
                    $em->flush();
                }
            }
        }
        foreach ($players as $player) {
            $player->setPerfect(0);
            $player->setPoints(0);
            $bets = $doctrine->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Bet')
                ->findBy(array(
                    'player' => $player
                ));
            foreach ($bets as $bet) {
                if ($bet->getPoints() != null) {
                    $player->setPoints($player->getPoints() + $bet->getPoints());
                    if ($bet->getBetHome() == $bet->getGame()->getScoreHome() && $bet->getBetAway() == $bet->getGame()->getScoreAway()) {
                        $player->setPerfect($player->getPerfect() + 1);
                    }
                    $em->persist($player);
                    $em->flush();
                }
            }
        }

        $request->getSession()->getFlashBag()->add('success', 'Ok, les scores ont été recalculés.');
        return $this->redirectToRoute('servicejf_admin_cm18_editGames');
    }

    public function emailAction(Request $request)
    {
        $games = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game')
            ->findPlayedGames();
        $mail = new RankingMail(count($games));
        $form = $this->createFormBuilder($mail)
            ->add('subject', TextType::class, array(
                'label' => 'Objet du mail :'
            ))
            ->add('firstTitle', TextType::class, array(
                'label' => 'Titre pour le premier joueur :',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Laisser libre pour mettre le même titre que pour tous les autres'
                )
            ))
            ->add('secondTitle', TextType::class, array(
                'label' => 'Titre pour le 2è joueur :',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Laisser libre pour mettre le même titre que pour tous les autres'
                )
            ))
            ->add('thirdTitle', TextType::class, array(
                'label' => 'Titre pour le 3è joueur :',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Laisser libre pour mettre le même titre que pour tous les autres'
                )
            ))
            ->add('lastTitle', TextType::class, array(
                'label' => 'Titre pour le dernier joueur :',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Laisser libre pour mettre le même titre que pour tous les autres'
                )
            ))
            ->add('defaultTitle', TextType::class, array(
                'label' => 'Titre pour tous les autres :'
            ))
            ->add('beginningContent', TextareaType::class, array(
                'label' => 'Texte à insérer avant le classement :'
            ))
            ->add('endingContent', TextareaType::class, array(
                'label' => 'Texte à insérer après le classement :'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Envoyer'
            ))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $players = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
                ->findForRankingMail();
            $ranking = $players;
            $placeholders = array(
                '{prénom}',
                '{matchsjoués}',
                '{points}'
            );
            $mailer = $this->get('servicejf.mailer');
            $mails = array();
            for ($i = 0, $size = count($players); $i < $size; $i++) {
                $mails[$i] = new RankingMail(count($games));
                $values = array(
                    $players[$i]->getIdentity()->getSurname(),
                    count($games),
                    $players[$i]->getPoints()
                );
                $mails[$i]->setPlayer($players[$i]);
                $mails[$i]->setSubject($mail->getSubject());
                $mails[$i]->setBeginningContent(str_replace($placeholders, $values, $mail->getBeginningContent()));
                $mails[$i]->setEndingContent(str_replace($placeholders, $values, $mail->getEndingContent()));
                if ($i == 0 && !empty($mail->getFirstTitle())) {
                    $mails[$i]->setTitle(str_replace($placeholders, $values, $mail->getFirstTitle()));
                } elseif ($i == 1 && !empty($mail->getSecondTitle())) {
                    $mails[$i]->setTitle(str_replace($placeholders, $values, $mail->getSecondTitle()));
                } elseif ($i == 2 && !empty($mail->getThirdTitle())) {
                    $mails[$i]->setTitle(str_replace($placeholders, $values, $mail->getThirdTitle()));
                } elseif ($i == count($players) - 1 && !empty($mail->getLastTitle())) {
                    $mails[$i]->setTitle(str_replace($placeholders, $values, $mail->getLastTitle()));
                } else {
                    $mails[$i]->setTitle(str_replace($placeholders, $values, $mail->getDefaultTitle()));
                }
                $mails[$i]->setEmail($players[$i]->getIdentity()->getEmail());
                $mailer->sendCM18RankingMail($mails[$i], $ranking);
            }
        }
        return $this->render('ServiceJFAdminBundle:Cm18:email.html.twig', array(
            'form' => $form->createView(),
            'mail' => $mail
        ));
    }
}