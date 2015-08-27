<?php

namespace Arkon\Bundle\PhoneBookBundle\Form;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractPhoneNumberType
 * @package Arkon\Bundle\PhoneBookBundle\Form
 */
abstract class AbstractPhoneNumberType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('number', 'integer', ['invalid_message' => '{{ value }} is not a valid number.']);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => PhoneNumber::class
        ]);
    }
}
