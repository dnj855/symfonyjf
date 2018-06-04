<?php
/**
 * User: cedriclangroth
 * Date: 14/05/2018
 * Time: 17:56
 */

namespace ServiceJF\AdminBundle\Form;

use ServiceJF\UserBundle\Form\UserCreateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserCM18GuestType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('roles')
            ->remove('manager');
    }

    public function getParent()
    {
        return UserCreateType::class;
    }

}