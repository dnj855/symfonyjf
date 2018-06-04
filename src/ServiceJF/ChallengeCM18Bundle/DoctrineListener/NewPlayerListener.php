<?php
/**
 * User: cedriclangroth
 * Date: 02/05/2018
 * Time: 14:49
 */

namespace ServiceJF\ChallengeCM18Bundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use ServiceJF\ChallengeCM18Bundle\Entity\Player;
use ServiceJF\CoreBundle\Mailer\Mailer;

class NewPlayerListener
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Player) {
            return;
        }

        $this->mailer->sendNewCm18PlayerMail($entity->getIdentity());
    }
}