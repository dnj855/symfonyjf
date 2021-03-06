<?php

namespace ServiceJF\ChallengeCIBundle\Form;

use Doctrine\ORM\EntityRepository;
use ServiceJF\UserBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('studio', ChoiceType::class, array(
                'choices' => array(
                    'yes' => true,
                    'no' => false
                ),
                'expanded' => true,
                'multiple' => false,
                'label' => 'label.studio'
            ))
            ->add('live', ChoiceType::class, array(
                'choices' => array(
                    'yes' => true,
                    'no' => false
                ),
                'expanded' => true,
                'multiple' => false,
                'label' => 'label.live'
            ))
            ->add('name', TextType::class, array(
                'label' => 'label.name'
            ))
            ->add('mandatoryRecorded', CheckboxType::class, array(
                'label' => 'label.mandatory',
                'required' => false
            ))
            ->add('date', DateType::class, array(
                'label' => 'label.date',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
            ->add('setter', EntityType::class, array(
                'class' => 'ServiceJFUserBundle:User',
                'choice_label' => function ($user) {
                    return $user->getSurname() . ' ' . $user->getName();
                },
                'query_builder' => function (UserRepository $ur) {
                    return $ur->findFromService(1);
                },
                'label' => 'label.setter'
            ))
            ->add('host', EntityType::class, array(
                'class' => 'ServiceJFUserBundle:User',
                'choice_label' => function ($user) {
                    return $user->getSurname() . ' ' . $user->getName();
                },
                'query_builder' => function (UserRepository $ur) {
                    return $ur->findFromService(1);
                },
                'label' => 'label.host'
            ))
            ->add('submit', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeCIBundle\Entity\Guest'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengecibundle_guest';
    }


}
