<?php

namespace Arkon\Bundle\UserBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditUserType
 * @package Arkon\Bundle\UserBundle\Form
 */
class EditUserType extends AbstractUserType
{
    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'method' => 'PUT',
            'validation_groups' => ['edit']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'user_edit';
    }
}
