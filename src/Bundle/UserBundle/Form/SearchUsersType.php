<?php

namespace Arkon\Bundle\UserBundle\Form;

use Arkon\Bundle\UserBundle\Search\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class SearchUsersType
 * @package Arkon\Bundle\UserBundle\Form
 */
class SearchUsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('nickname');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => UserSearch::class,
            'method' => 'GET'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
