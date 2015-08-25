<?php

namespace Arkon\Bundle\PhoneBookBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AddPhoneNumberType
 * @package Arkon\Bundle\PhoneBookBundle\Form
 */
class AddPhoneNumberType extends AbstractPhoneNumberType
{
    /**
     * @inheritDoc
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
        return 'phone_number_add';
    }
}
