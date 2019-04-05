<?php

namespace UserBundle\Form\Type\Frontend;

use UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'form.user.email',
                'translation_domain' => 'UserMessages',
                'attr' => [
                    'class' => 'form.user.email',
                    'placeholder' => 'validators.user.email.not_blank',
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'translation_domain' => 'UserMessages',
                'attr' => [
                    'class' => 'form.user.password.label',
                    'placeholder' => 'ui.password',

                ],
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'form.user.password.label',
                    'attr' => [
                        'placeholder' => 'validators.user.plainPassword.not_blank',
                    ]
                ],
                'second_options' => [
                    'label' => 'form.user.password.password_confirmation',
                    'attr' => [
                        'placeholder' => 'ui.repeat_password',
                    ]
                ],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => User::class]);
    }
}
