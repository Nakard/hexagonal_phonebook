<?php

namespace Arkon\Bundle\PhoneBookBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EditPhoneNumberType
 * @package Arkon\Bundle\PhoneBookBundle\Form
 */
class EditPhoneNumberType extends AbstractPhoneNumberType
{
    /**
     * @inheritDoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'method' => 'PUT'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'phone_number_edit';
    }
}
