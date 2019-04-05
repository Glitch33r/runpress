<?php

namespace UserBundle\Form\Type\Frontend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class PasswordResetEmailType extends AbstractType
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
                    'placeholder' => 'ui.email'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => null]);
    }
}
