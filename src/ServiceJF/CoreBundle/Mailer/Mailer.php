<?php
/**
 * User: cedriclangroth
 * Date: 01/05/2018
 * Time: 08:57
 */

namespace ServiceJF\CoreBundle\Mailer;


use ServiceJF\UserBundle\Entity\User;

class Mailer
{
    private $mailer;

    private $templating;

    public function __construct(\Swift_Mailer $mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendSimpleMail(User $user, $content, $subject)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('contact@servicejf.com', 'Service J&F:')
            ->setTo($user->getEmail(), $user->getSurname() . ' ' . $user->getName())
            ->setBody($this->templating->render('Emails/simpleMail.html.twig', array(
                'name' => $user->getSurname(),
                'content' => $content
            )), 'text/html');

        $this->mailer->send($message);
    }

    public function sendNewUserMail(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Bienvenue sur le portail du service j&f:')
            ->setFrom('contact@servicejf.com', 'Service J&F:')
            ->setTo($user->getEmail())
            ->setBody($this->templating->render('Emails/newUserMail.html.twig', array(
                'name' => $user->getSurname(),
                'login' => $user->getUsername()
            )), 'text/html');

        $this->mailer->send($message);
    }

}