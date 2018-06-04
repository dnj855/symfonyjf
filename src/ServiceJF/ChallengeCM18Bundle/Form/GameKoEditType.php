<?php

namespace ServiceJF\ChallengeCM18Bundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GameKoEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('fifaNumber')
            ->remove('date')
            ->remove('teamHome')
            ->remove('teamAway')
            ->remove('gamePhase');
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
