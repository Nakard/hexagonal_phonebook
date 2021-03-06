<?php

namespace Arkon\Bundle\UserBundle\Form;

use Arkon\Bundle\UserBundle\Search\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

        $builder->add('firstName', null, ['description' => 'First name to search for']);
        $builder->add('lastName', null, ['description' => 'Last name to search for']);
        $builder->add('nickname', null, ['description' => 'Nickname to search for']);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

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
        return 'user_search';
    }
}
