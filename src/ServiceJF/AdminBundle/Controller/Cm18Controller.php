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
use ServiceJF\ChallengeCM18Bundle\Entity\Team;
use ServiceJF\ChallengeCM18Bundle\Form\GameCreateType;
use ServiceJF\ChallengeCM18Bundle\Form\GameKoEditType;
use ServiceJF\ChallengeCM18Bundle\Form\GamePoolEditType;
use ServiceJF\ChallengeCM18Bundle\Form\GamePhaseType;
use ServiceJF\ChallengeCM18Bundle\Form\PoolType;
use ServiceJF\ChallengeCM18Bundle\Form\TeamType;
use ServiceJF\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Cm18Controller extends Controller
{
    public function createPoolAction(Request $request)
    {
        $pool = new Pool();
        $form = $this->createForm(PoolType::class, $pool);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pool);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La poule ' . $pool->getPool() . ' a bien été créée.');
            return $this->redirectToRoute('servicejf_admin_cm18_createPool');
        }
        return $this->render('ServiceJFAdminBundle:Cm18:createPool.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createGamePhaseAction(Request $request)
    {
        $gamePhase = new GamePhase();
        $form = $this->createForm(GamePhaseType::class, $gamePhase);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gamePhase);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La phase de jeu a bien été créée.');
            return $this->redirectToRoute('servicejf_admin_cm18_createGamePhase');
        }
        return $this->render('ServiceJFAdminBundle:Cm18:createPool.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function createTeamAction(Request $request)
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'L\'équipe ' . $team->getName() . ' a bien été créée.');
            return $this->redirectToRoute('servicejf_admin_cm18_createTeam');
        }
        $pools = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Pool')->findAll();
        return $this->render('ServiceJFAdminBundle:Cm18:createTeam.html.twig', array(
            'form' => $form->createView(),
            'pools' => $pools
        ));
    }

    public function createGameAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameCreateType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game->setPool($game->getTeamHome()->getPool());
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'La rencontre a bien été créée.');
            return $this->redirectToRoute('servicejf_admin_cm18_createGame');
        }
        return $this->render('ServiceJFAdminBundle:Cm18:createGame.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function addPlayersAction(Request $request)
    {
        $players = $this->getDoctrine()->getRepository('ServiceJF\UserBundle\Entity\User')
            ->findBy(array(
                'enabled' => true
            ), array(
                'surname' => 'ASC'
            ));
        $enabledPlayers = $this->getDoctrine()->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Player')
            ->findAll();
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $this->createForm(UserCM18GuestType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $user->addRole('ROLE_CM18_GUEST');
            $userManager->updateUser($user);
            $player = new Player($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($player);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'L\'invité a bien été créé.');
            return $this->redirectToRoute('servicejf_admin_cm18_addPlayers');
        }
        $betValue = $this->getParameter('cm18_betValue');
        return $this->render('ServiceJFAdminBundle:Cm18:addPlayers.html.twig', array(
            'players' => $players,
            'betValue' => $betValue,
            'form' => $form->createView(),
            'enabledPlayers' => $enabledPlayers
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
        if (new \DateTime() < $game->getDate()) {
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
}