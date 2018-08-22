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
use Symfony\Component\DependencyInjection\ContainerInterface;

class NewUserListener
{
    private $mailer;

    private $container;

    public function __construct(Mailer $mailer, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }
        if ($entity->hasRole('ROLE_CM18_GUEST')) {
            return;
        }
        if ($entity->hasRole('ROLE_JEUDI_GUEST')) {
            $this->mailer->sendNewJeudiGuestMail($entity);
        } else {
            $this->mailer->sendNewUserMail($entity);
        }
        if (null !== $entity->getPhoneNumber()) {
            $this->container->get('servicejf.smschecker')->checkProcess($entity);
        }
    }
}