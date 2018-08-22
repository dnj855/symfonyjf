<?php
// src/AppBundle/Form/RegistrationType.php

namespace ServiceJF\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;

class UserProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phoneNumber', TelType::class, array(
            'required' => false,
            'label' => 'Numéro de téléphone (optionnel)'
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'user_profile';
    }
}