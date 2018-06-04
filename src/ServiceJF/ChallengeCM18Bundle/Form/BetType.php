<?php

namespace ServiceJF\ChallengeCM18Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('betHome', NumberType::class, array(
                'label' => false
            ))
            ->add('betAway', NumberType::class, array(
                'label' => false
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
                'label' => 'Enregistrer'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServiceJF\ChallengeCM18Bundle\Entity\Bet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicejf_challengecm18bundle_bet';
    }


}
