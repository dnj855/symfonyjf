<?php
/**
 * User: cedriclangroth
 * Date: 02/05/2018
 * Time: 14:49
 */

namespace ServiceJF\CoreBundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use ServiceJF\CoreBundle\Mailer\Mailer;
use ServiceJF\UserBundle\Entity\User;

class NewUserListener
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        $this->mailer->sendNewUserMail($entity);
    }
}