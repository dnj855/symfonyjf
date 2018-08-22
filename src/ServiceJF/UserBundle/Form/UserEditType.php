<?php
/**
 * User: cedriclangroth
 * Date: 27/11/2017
 * Time: 23:38
 */

namespace ServiceJF\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('plainPassword')
        ->remove('save')
        ->add('save', SubmitType::class, array(
            'label' => 'submitButton.modify'
        ));
    }

    public function getParent()
{
    return UserCreateType::class;
}
}