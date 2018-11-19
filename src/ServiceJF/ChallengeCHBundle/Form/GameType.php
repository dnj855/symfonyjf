<?php

namespace ServiceJF\ChallengeCHBundle\Form;

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
            ->add('date', DateTimeType::class, array(
                'widget' => 'choice',
                'months' => range(11, 12),
                'years' => array(2018)
            ))
            ->add('scoreHome', NumberType::class, array(
                'label' => false
            ))
            ->add('scoreAway', NumberType::class, array(
                'label' => false
            ))
            ->add('teamHome', EntityType::class, array(
                'class' => 'ServiceJFChallengeCHBundle:Team',
                'choice_label' => 'Name',
                'placeholder' => '---Choisir---',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'label' => 'Equipe 1'
            ))
            ->add('teamAway', EntityType::class, array(
                'class' => 'ServiceJFChallengeCHBundle:Team',
                'choice_label' => 'Name',
                'placeholder' => '---Choisir---',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.name', 'ASC');
                },
                'label' => 'Equipe 2'
            ))
            ->add('gamePhase', EntityType::class, array(
                'class' => 'ServiceJFChallengeCHBundle:GamePhase',
                'choice_label' => 'Name',
                'label' => 'Phase de jeu',
                'placeholder' => '---Choisir---',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.id', 'ASC');
                },
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
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeCHBundle\Entity\Game'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengechbundle_game';
    }


}
