<?php
/**
 * User: cedriclangroth
 * Date: 10/05/2018
 * Time: 22:11
 */

namespace ServiceJF\ChallengeCM18Bundle\Services;


use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeCM18Bundle\Entity\Game;

class GamesCalculator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function calculateGame(Game $game)
    {
        if ($this->checkPoolGame($game)) {
            $this->treatGame($game);
        } elseif ($this->checkKnockOutGame($game)) {
            $this->treatGame($game);
        } else {
            return false;
        }
    }

    public function checkKnockOutGame(Game $game)
    {
        $treatedGames = array(49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62);
        if (in_array($game->getFifaNumber(), $treatedGames)) {
            return true;
        } else {
            return false;
        }

    }

    public function checkPoolGame(Game $game)
    {
        $treatedGames = array(33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48);
        if (in_array($game->getFifaNumber(), $treatedGames)) {
            $poolTeams = $game->getPool()->getTeams();
            $playedGames = array();
            foreach ($poolTeams as $team) {
                $playedGames[] = $team->getPlayedGames();
            }
            if (in_array(2, $playedGames) || in_array(1, $playedGames) || in_array(0, $playedGames)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function treatGame(Game $game)
    {
        if ($game->getPool()) {
            $teams = $this->em->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Team')
                ->findRankingByPool($game->getPool());
        }
        switch ($game->getFifaNumber()) {
            case 33:
            case 34:
                $this->setGame(49, new \DateTime('2018-06-30 20:00:00'), $teams[0], true);
                $this->setGame(51, new \DateTime('2018-07-01 16:00:00'), $teams[1], false);
                break;
            case 35:
            case 36:
                $this->setGame(51, new \DateTime('2018-07-01 16:00:00'), $teams[0], true);
                $this->setGame(49, new \DateTime('2018-06-30 20:00:00'), $teams[1], false);
                break;
            case 37:
            case 38:
                $this->setGame(50, new \DateTime('2018-06-30 16:00:00'), $teams[0], true);
                $this->setGame(52, new \DateTime('2018-07-01 20:00:00'), $teams[1], false);
                break;
            case 39:
            case 40:
                $this->setGame(52, new \DateTime('2018-07-01 20:00:00'), $teams[0], true);
                $this->setGame(50, new \DateTime('2018-06-30 16:00:00'), $teams[1], false);
                break;
            case 41:
            case 42:
                $this->setGame(53, new \DateTime('2018-07-02 16:00:00'), $teams[0], true);
                $this->setGame(55, new \DateTime('2018-07-03 16:00:00'), $teams[1], false);
                break;
            case 43:
            case 44:
                $this->setGame(55, new \DateTime('2018-07-03 16:00:00'), $teams[0], true);
                $this->setGame(53, new \DateTime('2018-07-02 16:00:00'), $teams[1], false);
                break;
            case 45:
            case 46:
                $this->setGame(54, new \DateTime('2018-07-02 20:00:00'), $teams[0], true);
                $this->setGame(56, new \DateTime('2018-07-03 20:00:00'), $teams[1], false);
                break;
            case 47:
            case 48:
                $this->setGame(56, new \DateTime('2018-07-03 20:00:00'), $teams[0], true);
                $this->setGame(54, new \DateTime('2018-07-02 20:00:00'), $teams[1], false);
                break;
            case 49:
                $this->setGame(57, new \DateTime('2018-07-06 16:00:00'), $this->getWinningTeam($game), true);
                break;
            case 50:
                $this->setGame(57, new \DateTime('2018-07-06 16:00:00'), $this->getWinningTeam($game), false);
                break;
            case 51:
                $this->setGame(59, new \DateTime('2018-07-07 20:00:00'), $this->getWinningTeam($game), true);
                break;
            case 52:
                $this->setGame(59, new \DateTime('2018-07-07 20:00:00'), $this->getWinningTeam($game), false);
                break;
            case 53:
                $this->setGame(58, new \DateTime('2018-07-06 20:00:00'), $this->getWinningTeam($game), true);
                break;
            case 54:
                $this->setGame(58, new \DateTime('2018-07-06 20:00:00'), $this->getWinningTeam($game), false);
                break;
            case 55:
                $this->setGame(60, new \DateTime('2018-07-07 16:00:00'), $this->getWinningTeam($game), true);
                break;
            case 56:
                $this->setGame(60, new \DateTime('2018-07-07 16:00:00'), $this->getWinningTeam($game), false);
                break;
            case 57:
                $this->setGame(61, new \DateTime('2018-07-10 20:00:00'), $this->getWinningTeam($game), true);
                break;
            case 58:
                $this->setGame(61, new \DateTime('2018-07-10 20:00:00'), $this->getWinningTeam($game), false);
                break;
            case 59:
                $this->setGame(62, new \DateTime('2018-07-11 20:00:00'), $this->getWinningTeam($game), true);
                break;
            case 60:
                $this->setGame(62, new \DateTime('2018-07-11 20:00:00'), $this->getWinningTeam($game), false);
                break;
            case 61:
                $this->setGame(64, new \DateTime('2018-07-15 17:00:00'), $this->getWinningTeam($game), true);
                $this->setGame(63, new \DateTime('2018-07-14 16:00:00'), $this->getLoosingTeam($game), true);
                break;
            case 62:
                $this->setGame(64, new \DateTime('2018-07-15 17:00:00'), $this->getWinningTeam($game), false);
                $this->setGame(63, new \DateTime('2018-07-14 16:00:00'), $this->getLoosingTeam($game), false);
                break;
        }
    }

    public function setGame($fifaNumber, \DateTime $date, $team, $home)
    {
        $gamePhase = $this->getGamePhase($fifaNumber);
        $gameRepository = $this->em->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\Game');
        $game = $gameRepository->findOneBy(array(
            'fifaNumber' => $fifaNumber
        ));
        if (!$game instanceof Game) {
            $game = new Game();
            $game->setDate($date);
            $game->setFifaNumber($fifaNumber);
            $game->setGamePhase($gamePhase);
        }
        if ($home) {
            $game->setTeamHome($team);
        } else {
            $game->setTeamAway($team);
        }
        $this->em->persist($game);
        $this->em->flush();
    }

    public function getGamePhase($fifaNumber)
    {
        $gamePhaseRepository = $this->em->getRepository('ServiceJF\ChallengeCM18Bundle\Entity\GamePhase');
        switch ($fifaNumber) {
            case 49:
            case 50:
            case 51:
            case 52:
            case 53:
            case 54:
            case 55:
            case 56:
                return $gamePhaseRepository->findOneBy(array(
                    'name' => '8è de finale'
                ));
                break;
            case 57:
            case 58:
            case 59:
            case 60:
                return $gamePhaseRepository->findOneBy(array(
                    'name' => 'Quart de finale'
                ));
                break;
            case 61:
            case 62:
                return $gamePhaseRepository->findOneBy(array(
                    'name' => 'Demi-finale'
                ));
                break;
            case 63:
                return $gamePhaseRepository->findOneBy(array(
                    'name' => 'Petite finale'
                ));
                break;
            case 64:
                return $gamePhaseRepository->findOneBy(array(
                    'name' => 'Finale'
                ));
                break;
        }
    }

    public function getWinningTeam(Game $game)
    {
        if ($game->getWinner() == 'home') {
            return $game->getTeamHome();
        } else {
            return $game->getTeamAway();
        }
    }

    public function getLoosingTeam(Game $game)
    {
        if ($game->getWinner() == 'home') {
            return $game->getTeamAway();
        } else {
            return $game->getTeamHome();
        }
    }
}