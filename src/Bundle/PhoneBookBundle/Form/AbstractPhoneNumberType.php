<?php

namespace Arkon\Bundle\PhoneBookBundle\Form;

use Arkon\Bundle\PhoneBookBundle\Entity\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class AbstractPhoneNumberType
 * @package Arkon\Bundle\PhoneBookBundle\Form
 */
class AbstractPhoneNumberType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('number', 'integer');
    }

    /**
     * @inheritDoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => PhoneNumber::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'phoneNumber';
    }
}
