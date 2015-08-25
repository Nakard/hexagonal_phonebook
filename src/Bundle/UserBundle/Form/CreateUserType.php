<?php

namespace Arkon\Bundle\UserBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CreateUserType
 * @package Arkon\Bundle\UserBundle\Form
 */
class CreateUserType extends AbstractUserType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

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
