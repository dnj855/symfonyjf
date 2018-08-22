<?php

namespace ServiceJF\ChallengeCSSBundle\Form;

use Doctrine\ORM\EntityRepository;
use ServiceJF\UserBundle\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gameNumber', NumberType::class, array(
                'scale' => 0,
                'label' => 'Journée n° :'
            ))
            ->add('date', DateType::class, array(
                'label' => 'Date du match :',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ))
            ->add('home', ChoiceType::class, array(
                'choices' => array(
                    'à domicile' => true,
                    'à l\'extérieur' => false
                ),
                'label' => 'Le FC Metz joue :',
                'placeholder' => false,
                'expanded' => true,
                'multiple' => false
            ))
            ->add('scoreFCMetz', NumberType::class, array(
                'label' => 'Score - FC Metz :'
            ))
            ->add('scoreOpponent', NumberType::class, array(
            ))
            ->add('director', EntityType::class, array(
                'class' => 'ServiceJFUserBundle:User',
                'label' => 'Réalisateur :',
                'choice_label' => function ($user) {
                    return $user->getSurname() . ' ' . $user->getName();
                },
                'query_builder' => function (UserRepository $ur) {
                    return $ur->findFromService(2);
                },
                'placeholder' => 'Choisir'
            ))
            ->add('opponent', EntityType::class, array(
                'class' => 'ServiceJFChallengeCSSBundle:Team',
                'choice_label' => 'name',
                'label' => 'Adversaire :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->where('t.enabled = 1')
                        ->orderBy('t.name', 'ASC');
                }
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeCSSBundle\Entity\Game'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengecssbundle_game';
    }


}
