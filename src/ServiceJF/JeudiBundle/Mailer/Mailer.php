<?php
/**
 * User: cedriclangroth
 * Date: 26/07/2018
 * Time: 11:54
 */

namespace ServiceJF\JeudiBundle\Mailer;

use Doctrine\ORM\PersistentCollection;
use ServiceJF\JeudiBundle\Entity\Apero;
use ServiceJF\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Mailer
{
    private $mailer;

    private $templating;

    private $container;

    public function __construct(\Swift_Mailer $mailer, $templating, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->container = $container;
    }

    public function confirmMail(PersistentCollection $interestedUsers, Apero $apero)
    {
        foreach ($interestedUsers as $user) {
            $message = \Swift_Message::newInstance()
                ->setSubject('L\'apéro #' . $apero->getNumber() . ' est confirmé !')
                ->setFrom('aperodujeudi@servicejf.com', 'L\'apéro du jeudi')
                ->setTo($user->getEmail())
                ->setBody($this->templating->render('Emails/Jeudi/confirmMail.html.twig', array(
                    'apero' => $apero,
                    'user' => $user
                )), 'text/html');
            $this->mailer->send($message);
        }
    }

    public function rejectMail(PersistentCollection $interestedUsers, Apero $apero)
    {
        $nextDate = clone $apero->getDate();
        $nextDate->modify('+7 days');
        $nextApero = new Apero($nextDate, $apero->getNumber());
        foreach ($interestedUsers as $user) {
            $message = \Swift_Message::newInstance()
                ->setSubject('L\'apéro #' . $apero->getNumber() . ' est annulé !')
                ->setFrom('aperodujeudi@servicejf.com', 'L\'apéro du jeudi')
                ->setTo($user->getEmail())
                ->setBody($this->templating->render('Emails/Jeudi/rejectMail.html.twig', array(
                    'apero' => $apero,
                    'nextApero' => $nextApero,
                    'user' => $user
                )), 'text/html');
            $this->mailer->send($message);
        }
    }

    public function timeAndPlaceMail(PersistentCollection $interestedUsers, Apero $apero, $first, $place = null, $time = null)
    {
        foreach ($interestedUsers as $user) {
            if ($first) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Des détails sur l\'apéro #' . $apero->getNumber() . ' !')
                    ->setFrom('aperodujeudi@servicejf.com', 'L\'apéro du jeudi')
                    ->setTo($user->getEmail())
                    ->setBody($this->templating->render('Emails/Jeudi/firstTimeAndPlaceMail.html.twig', array(
                        'apero' => $apero,
                        'user' => $user
                    )), 'text/html');
            } else {
                if ($place && $time) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Modification de l\'horaire et du lieu de l\'apéro #' . $apero->getNumber() . ' !')
                        ->setFrom('aperodujeudi@servicejf.com', 'L\'apéro du jeudi')
                        ->setTo($user->getEmail())
                        ->setBody($this->templating->render('Emails/Jeudi/modifyTimeAndPlaceMail.html.twig', array(
                            'apero' => $apero,
                            'user' => $user,
                            'place' => $place,
                            'time' => $time
                        )), 'text/html');
                } elseif ($place) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Modification du lieu de l\'apéro #' . $apero->getNumber() . ' !')
                        ->setFrom('aperodujeudi@servicejf.com', 'L\'apéro du jeudi')
                        ->setTo($user->getEmail())
                        ->setBody($this->templating->render('Emails/Jeudi/modifyTimeAndPlaceMail.html.twig', array(
                            'apero' => $apero,
                            'user' => $user,
                            'place' => $place,
                            'time' => $time
                        )), 'text/html');
                } elseif ($time) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Modification de l\'horaire de l\'apéro #' . $apero->getNumber() . ' !')
                        ->setFrom('aperodujeudi@servicejf.com', 'L\'apéro du jeudi')
                        ->setTo($user->getEmail())
                        ->setBody($this->templating->render('Emails/Jeudi/modifyTimeAndPlaceMail.html.twig', array(
                            'apero' => $apero,
                            'user' => $user,
                            'place' => $place,
                            'time' => $time
                        )), 'text/html');
                }
            }
            $this->mailer->send($message);
        }
    }
}