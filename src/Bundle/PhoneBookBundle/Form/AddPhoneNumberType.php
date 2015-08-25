<?php

namespace Arkon\Bundle\PhoneBookBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddPhoneNumberType
 * @package Arkon\Bundle\PhoneBookBundle\Form
 */
class AddPhoneNumberType extends AbstractPhoneNumberType
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
        return 'phone_number_add';
    }
}
