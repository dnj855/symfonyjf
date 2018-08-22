<?php
/**
 * User: cedriclangroth
 * Date: 01/05/2018
 * Time: 08:57
 */

namespace ServiceJF\CoreBundle\Mailer;


use Doctrine\ORM\EntityManager;
use ServiceJF\ChallengeCM18Bundle\Entity\Player;
use ServiceJF\ChallengeCM18Bundle\Entity\RankingMail;
use ServiceJF\ChallengeDLBundle\Entity\GamePhase;
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

    public function sendNewCm18PlayerMail(User $user)
    {
        $pointsFinalWinner = $this->container->getParameter('cm18_points_finalWinner');
        $points1n2 = $this->container->getParameter('cm18_points_1n2');
        $pointsPerfect = $this->container->getParameter('cm18_points_perfect');
        $pointsKoWinner = $this->container->getParameter('cm18_points_koWinner');
        $message = \Swift_Message::newInstance()
            ->setSubject('Ton inscription au challenge du mondial 2018 est validée !')
            ->setFrom('contact@servicejf.com', 'Service J&F:')
            ->setTo($user->getEmail())
            ->setBody($this->templating->render('Emails/newCm18PlayerMail.html.twig', array(
                'name' => $user->getSurname(),
                'points1n2' => $points1n2,
                'pointsFinalWinner' => $pointsFinalWinner,
                'pointsPerfect' => $pointsPerfect,
                'pointsKoWinner' => $pointsKoWinner
            )), 'text/html');

        $this->mailer->send($message);
    }

    public function sendDlSetBetMail(GamePhase $gamePhase)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Ta dead list a été validée !')
            ->setFrom('contact@servicejf.com', 'ServiceJ&F:')
            ->setTo($gamePhase->getBetter()->getEmail())
            ->setBody($this->templating->render('Emails/dlSetBetMail.html.twig', array(
                'user' => $gamePhase->getBetter(),
                'bets' => $gamePhase->getBets()
            )), 'text/html');

        $this->mailer->send($message);
    }

    public function sendFgReminderMail(User $user, $votes)
    {
        $now = new \DateTimeImmutable();
        $endVotes = $now->modify('last day of this month');
        $remainingTime = $now->diff($endVotes);
        $message = \Swift_Message::newInstance()
            ->setSubject('Plus que quelques jours pour voter !')
            ->setFrom('contact@servicejf.com', 'Service J&F:')
            ->setTo($user->getEmail())
            ->setBody($this->templating->render('Emails/fgMonthlyReminder.html.twig', array(
                'user' => $user->getSurname(),
                'votes' => $votes,
                'remainingTime' => $remainingTime
            )), 'text/html');

        $this->mailer->send($message);
    }

    public function sendCM18RankingMail(RankingMail $mail, $ranking)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('[mondial 2018] ' . $mail->getSubject())
            ->setFrom('contact@servicejf.com', 'Service J&F:')
            ->setTo($mail->getEmail())
            ->setBody($this->templating->render('Emails/cm18RankingMail.html.twig', array(
                'title' => $mail->getTitle(),
                'ranking' => $ranking,
                'beginningContent' => $mail->getBeginningContent(),
                'endingContent' => $mail->getEndingContent()
            )), 'text/html');

        $this->mailer->send($message);
        return true;
    }

    public function sendNewJeudiGuestMail(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Bienvenue à l\'apéro du jeudi !')
            ->setFrom('aperodujeudi@servicejf.com', 'Service J&F:')
            ->setTo($user->getEmail())
            ->setBody($this->templating->render('Emails/Jeudi/newGuestMail.html.twig', array(
                'name' => $user->getSurname(),
                'login' => $user->getUsername()
            )), 'text/html');

        $this->mailer->send($message);
    }

}