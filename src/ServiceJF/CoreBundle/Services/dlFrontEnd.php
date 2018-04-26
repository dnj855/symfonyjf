<?php
/**
 * User: cedriclangroth
 * Date: 28/03/2018
 * Time: 08:17
 */

namespace ServiceJF\CoreBundle\Services;


class dlFrontEnd
{
    public function getHomeAndNavigation($gamePhase, $countdown)
    {
        if (new \DateTime() < new \DateTime($countdown)) {
            if ($gamePhase == 'newPlayer' || $gamePhase == 'stillBetting') {
                return 'Enregistrer ses paris';
            } else {
                return 'Voir les résultats';
            }
        } else {
            return 'Voir les résultats';
        }
    }
}