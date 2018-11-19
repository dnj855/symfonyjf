<?php

namespace ServiceJF\ChallengeCHBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GamePoolEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('date')
            ->remove('teamHome')
            ->remove('teamAway')
            ->remove('gamePhase')
            ->remove('winner');
    }

    public function getParent()
    {
        return GameType::class;
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'servicejf_challengecm18bundle_game';
//    }


}
