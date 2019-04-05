<?php

namespace UserBundle\Form\Type\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class UserLoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_username', TextType::class, [
                'label' => 'form.user.email',
                'translation_domain' => 'UserMessages',
                'attr' => [
                    'placeholder' => 'ui.email',
                ]
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'form.user.password.label',
                'attr' => [
                    'placeholder' => 'form.login.password',
                ],
                'translation_domain' => 'UserMessages',
            ])
            ->add('_remember_me', CheckboxType::class, [
                'label' => 'form.login.remember_me',
                'translation_domain' => 'UserMessages',
                'required' => false,
            ]);
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
