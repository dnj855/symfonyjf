<?php

namespace ServiceJF\ChallengeCHBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GameUpdateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('date')
            ->remove('gamePhase')
        ->remove('teamHome')
        ->remove('teamAway');
    }

    public function getParent()
    {
        return GameType::class;
    }
}