<?php

namespace Arkon\Bundle\PhoneBookBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EditPhoneNumberType
 * @package Arkon\Bundle\PhoneBookBundle\Form
 */
class EditPhoneNumberType extends AbstractPhoneNumberType
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
        return 'phone_number_edit';
    }
}
