<?php

namespace Arkon\Bundle\UserBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EditUserType
 * @package Arkon\Bundle\UserBundle\Form
 */
class EditUserType extends AbstractUserType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'method' => 'PUT'
        ]);
    }
}
