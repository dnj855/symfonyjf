<?php
/**
 * User: cedriclangroth
 * Date: 13/12/2017
 * Time: 21:20
 */

namespace ServiceJF\MigrationBundle\Form;


use ServiceJF\UserBundle\Form\UserCreateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UserMigrateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('manager')
            ->remove('surname')
            ->remove('name')
            ->remove('service')
            ->remove('roles')
        ->remove('save')
        ->add('submit', SubmitType::class, array(
            'label' => 'button.modify'
        ));
    }

    public function getParent()
    {
        return UserCreateType::class;
    }
}