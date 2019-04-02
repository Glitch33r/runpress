<?php

namespace BackendBundle\Form\Type\Dashboard;

use BackendBundle\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use IhorDrevetskyi\UploadBundle\Form\Type\UploadType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use IhorDrevetskyi\SeoBundle\Form\Type\Dashboard\SeoType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardTextType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardYesNoType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\AddSaveBtnSubscriber;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardWYSIWYGType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardPositionType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardTextareaType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardDateTimeType;
use IhorDrevetskyi\DashboardBundle\Form\Type\NewEdit\DashboardTranslationsType;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class VideoType extends AbstractType
{
    /**
     * @var Security
     */
    protected $security;

    /**
     * StaticContentType constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', DashboardTranslationsType::class, [
                'label' => false,
                'fields' => [
                    'title' => [
                        'field_type' => DashboardTextType::class,
                        'label' => 'ui.title',
                        'translation_domain' => 'DashboardBundle',
                        'help_block' => null,
                        'max_length' => 255
                    ]
                ],
                'excluded_fields' => [
                    'slug', 'id', 'locale', 'translatable', 'createdAt', 'updatedAt', 'treeTitle'
                ]
            ])
            ->add('seo', SeoType::class)
            ->add('iframe', DashboardTextareaType::class, [
                'label' => 'Iframe url',
                'required' => false,
            ])
            ->add('publishAt', DashboardDateTimeType::class, [
                'label' => 'ui.datetime',
                'required' => false,
                'translation_domain' => 'DashboardBundle',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd.MM.yyyy HH:mm'
            ])
            ->add('position', DashboardPositionType::class, [
                'label' => 'ui.position',
                'required' => false,
                'translation_domain' => 'DashboardBundle',
                'div_lg' => 'col-lg-8',
                'label_lg' => 'col-lg-4'
            ])
            ->add('showOnWebsite', DashboardYesNoType::class, [
                'label' => 'ui.show_on_website',
                'required' => false,
                'translation_domain' => 'DashboardBundle',
                'div_lg' => 'col-lg-6',
                'label_lg' => 'col-lg-6'
            ]);

        $builder
            ->addEventSubscriber(new AddSaveBtnSubscriber($this->security));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(['data_class' => Video::class, 'grantedRoles' => null]);
    }
}
