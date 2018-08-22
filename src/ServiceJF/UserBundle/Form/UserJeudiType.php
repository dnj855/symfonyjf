<?php
/**
 * User: cedriclangroth
 * Date: 02/08/2018
 * Time: 10:04
 */

namespace ServiceJF\UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;

class UserJeudiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('manager')
            ->remove('service')
            ->remove('plainPassword')
            ->remove('roles')
            ->add('phoneNumber', TelType::class, array(
                'required' => false,
                'label' => 'Numéro de téléphone (optionnel) :'
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options' => array('label' => 'Tape ton mot de passe :'),
                'second_options' => array('label' => 'Retape ton mot de passe :')
            ))
            ->remove('save')
            ->add('save', SubmitType::class, array(
                'label' => 'Valide ton inscription'
            ));
    }

    public function getParent()
    {
        return UserCreateType::class;
    }
}