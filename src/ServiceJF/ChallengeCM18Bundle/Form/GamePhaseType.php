<?php

namespace ServiceJF\ChallengeCM18Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GamePhaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom de la phase de jeu :'
            ))
            ->add('eliminatory', ChoiceType::class, array(
                'label' => 'Eliminatoire ?',
                'choices' => array(
                    'Oui' => true,
                    'Non' => false
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('final', ChoiceType::class, array(
                'label' => 'Finale ?',
                'choices' => array(
                    'Oui' => true,
                    'Non' => false
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Créer'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeCM18Bundle\Entity\GamePhase'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengecm18bundle_gamephase';
    }


}
