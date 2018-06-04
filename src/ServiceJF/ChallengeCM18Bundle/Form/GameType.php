<?php

namespace ServiceJF\ChallengeCM18Bundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('fifaNumber', NumberType::class, array(
                'label' => "N° FIFA :"
            ))
            ->add('scoreHome', NumberType::class, array(
                'label' => false
            ))
            ->add('scoreAway', NumberType::class, array(
                'label' => false
            ))
            ->add('date', DateTimeType::class, array(
                'widget' => 'choice',
                'label' => 'Date et heure :',
                'years' => array(2018),
                'months' => array(6, 7)
            ))
            ->add('teamHome', EntityType::class, array(
                'class' => 'ServiceJFChallengeCM18Bundle:Team',
                'choice_label' => 'name',
                'label' => 'Equipe A :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'expanded' => false,
                'multiple' => false
            ))
            ->add('teamAway', EntityType::class, array(
                'class' => 'ServiceJFChallengeCM18Bundle:Team',
                'choice_label' => 'name',
                'label' => 'Equipe B :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'expanded' => false,
                'multiple' => false
            ))
            ->add('gamePhase', EntityType::class, array(
                'class' => 'ServiceJFChallengeCM18Bundle:GamePhase',
                'choice_label' => 'name',
                'label' => 'Phase de jeu :',
                'expanded' => false,
                'multiple' => false
            ))
            ->add('winner', ChoiceType::class, array(
                'choices' => array(
                    'home' => 'home',
                    'away' => 'away'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => false,
                'label' => false,
                'choice_label' => false,
                'placeholder' => false
            ))
            ->add('submit', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeCM18Bundle\Entity\Game'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengecm18bundle_game';
    }


}
