<?php

namespace Arkon\Bundle\UserBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CreateUserType
 * @package Arkon\Bundle\UserBundle\Form
 */
class CreateUserType extends AbstractUserType
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'method' => 'POST'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'user_create';
    }
}
