<?php

namespace ServiceJF\ChallengeCHBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PoolBetType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('winner');
    }

    public function getParent()
    {
        return BetType::class;
    }


}
