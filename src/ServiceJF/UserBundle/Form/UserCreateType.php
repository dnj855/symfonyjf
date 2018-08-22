<?php

namespace ServiceJF\UserBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCreateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('manager', CheckboxType::class, array(
                'required' => false,
                'label' => 'label.manager'
            ))
            ->add('surname', TextType::class, array(
                'label' => 'label.firstName'
            ))
            ->add('name', TextType::class, array(
                'label' => 'label.lastName'
            ))
            ->add('service', EntityType::class, array(
                'label' => 'label.service',
                'class' => 'ServiceJFCoreBundle:Service',
                'choice_label' => 'name'
            ))
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'label.password'
            ))
            ->add('username', TextType::class, array(
                'label' => 'label.id'
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'submitButton.create'
            ))
            ->add('email', EmailType::class, array(
                'label' => 'label.email',
                'required' => 'true'
            ))
            ->add('roles', ChoiceType::class, array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'label' => false,
                    'placeholder' => '--Choisir--',
                    'choices' => array(
                        ' Soirées sport' => 'ROLE_CSS',
                        ' Administrateur' => 'ROLE_ADMIN',
                        ' Admin du jeudi' => 'ROLE_JEUDI_ADMIN',
                        ' Apéro du jeudi' => 'ROLE_JEUDI_GUEST'
                    )
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_userbundle_user';
    }


}
