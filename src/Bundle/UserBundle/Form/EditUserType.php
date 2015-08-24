<?php

namespace Arkon\Bundle\UserBundle\Form;

use Arkon\Bundle\UserBundle\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class EditUserType
 * @package Arkon\Bundle\UserBundle\Form
 */
class EditUserType extends AbstractUserType
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'method' => 'PUT',
            'validation_groups' => function (FormInterface $form) {
                if ($form->has('changed_nickname')) {
                    return ['edit', 'unique'];
                }

                return ['edit'];
            }
        ]);
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            /** @var User $user */
            $user = $event->getForm()->getData();

            if ($data['nickname'] === $user->getNickname()) {
                return;
            }
            $event->getForm()->add('changed_nickname', null, ['mapped' => false]);
        });

    }
}
