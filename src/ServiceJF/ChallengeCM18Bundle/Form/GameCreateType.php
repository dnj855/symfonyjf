<?php

namespace ServiceJF\ChallengeCM18Bundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GameCreateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('scoreHome')
            ->remove('scoreAway')
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
