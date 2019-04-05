<?php

namespace NewsBundle\Form\Type\Dashboard;

use NewsBundle\Entity\News;
use NewsBundle\Entity\NewsTag;
use NewsBundle\Entity\NewsAuthor;
use NewsBundle\Entity\NewsElement;
use Doctrine\ORM\EntityRepository;
use NewsBundle\Entity\NewsCategory;
use UploadBundle\Form\Type\UploadType;
use NewsBundle\Entity\NewsGalleryImage;
use Symfony\Component\Form\AbstractType;
use SeoBundle\Form\Type\Dashboard\SeoType;
use Symfony\Component\Security\Core\Security;
use DashboardBundle\Form\Type\DashboardUrlType;
use Symfony\Component\Form\FormBuilderInterface;
use DashboardBundle\Form\Type\DashboardTextType;
use DashboardBundle\Form\Type\DashboardFormType;
use DashboardBundle\Form\Type\DashboardYesNoType;
use SeoBundle\Form\Type\Dashboard\AddSeoSubscriber;
use DashboardBundle\Form\Type\AddSaveBtnSubscriber;
use DashboardBundle\Form\Type\DashboardWYSIWYGType;
use DashboardBundle\Form\Type\DashboardPositionType;
use DashboardBundle\Form\Type\DashboardTextareaType;
use DashboardBundle\Form\Type\DashboardDateTimeType;
use DashboardBundle\Form\Type\DashboardCollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DashboardBundle\Form\Type\DashboardTranslationsType;
use DashboardBundle\Form\Type\DashboardSelect2EntityType;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class NewsType extends AbstractType
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
            ->add(
                $builder->create('seo', DashboardFormType::class, [
                    'inherit_data' => true,
                    'tabName' => 'sidebar.configuration.seo',
                    'translation_domain' => 'SeoBundle',
                    'tabIcon' => 'flaticon-stopwatch'
                ])
                    ->add('seo', SeoType::class)
            )
            ->add(
                $builder
                    ->create('translations', DashboardFormType::class, [
                        'inherit_data' => true,
                        'tabName' => 'ui.general_info',
                    ])
                    ->add('translations', DashboardTranslationsType::class, [
                        'label' => false,
                        'fields' => [
                            'title' => [
                                'field_type' => DashboardTextareaType::class,
                                'label' => 'ui.title',
                                'helpBlock' => null,
                                'maxLength' => 255
                            ],
                            'posterAlt' => [
                                'field_type' => DashboardTextType::class,
                                'label' => 'ui.poster_alt',
                                'translation_domain' => 'DashboardBundle',
                                'helpBlock' => null,
                                'maxLength' => 255,
                                'required' => false,
                            ],
                            'signature' => [
                                'field_type' => DashboardTextType::class,
                                'label' => 'Подпись под слайдером',
                                'translation_domain' => 'NewsBundle',
                                'helpBlock' => null,
                                'maxLength' => 255,
                                'required' => false,
                            ],
                            'shortDescription' => [
                                'field_type' => DashboardTextareaType::class,
                                'label' => 'form.short_description',
                                'required' => false,
                            ],
                            'description' => [
                                'field_type' => DashboardWYSIWYGType::class,
                                'required' => false,
                                'label' => 'Все содержание',
                            ]
                        ],
                        'excluded_fields' => [
                            'slug', 'id', 'locale', 'translatable', 'createdAt', 'updatedAt', 'treeTitle'
                        ]
                    ])
                    ->add('newsCategory', DashboardSelect2EntityType::class, [
                        'required' => false,
                        'label' => 'ui.category',
                        'class' => NewsCategory::class,
                        'choice_label' => 'translate.title',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->getNewsCategoryForNewsForm();
                        },
                    ])
                    ->add('newsAuthor', DashboardSelect2EntityType::class, [
                        'required' => false,
                        'label' => 'select_author',
                        'translation_domain' => 'NewsBundle',
                        'class' => NewsAuthor::class,
                        'choice_label' => 'translate.title',
                        'query_builder' => function (EntityRepository $er) {
                            return $er->getNewsAuthorForNewsForm();
                        },
                    ])
                    ->add('video', DashboardTextType::class, [
                        'label' => 'ui.video',
                        'required' => false,
                    ])
                    ->add('signatureUrl', DashboardUrlType::class, [
                        'label' => 'signature_url',
                        'required' => false,
                        'translation_domain' => 'NewsBundle'
                    ])
                    ->add('poster', UploadType::class, [
                        'file_type' => 'news_poster',
                        'extensions' => '.jpg, .gif, .png, .svg',
                        'label' => 'ui.image',
                        'required' => false,
                    ])
                    ->add('publishAt', DashboardDateTimeType::class, [
                        'label' => 'ui.datetime',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'format' => 'dd.MM.yyyy HH:mm'
                    ])
                    ->add(
                        $builder->create('positionShowOnWebsiteIsMain', DashboardFormType::class, [
                            'inherit_data' => true,
                            'useGroupFields' => true,
                            'translation_domain' => null
                        ])
                            ->add('showOnWebsite', DashboardYesNoType::class, [
                                'label' => 'ui.show_on_website',
                                'required' => false,
                                'useFormGroup' => false,
                                'divLg' => 'col-lg-6',
                                'labelLg' => 'col-lg-6'
                            ])
                            ->add('isMain', DashboardYesNoType::class, [
                                'label' => 'is_main_news',
                                'required' => false,
                                'translation_domain' => 'NewsBundle',
                                'useFormGroup' => false,
                                'divLg' => 'col-lg-6',
                                'labelLg' => 'col-lg-6'
                            ])
                            ->add('position', DashboardPositionType::class, [
                                'label' => 'ui.position',
                                'required' => false,
                                'useFormGroup' => false,
                                'divLg' => 'col-lg-6',
                                'labelLg' => 'col-lg-6'
                            ])
                    )
            )
            ->add(
                $builder->create('elements', DashboardFormType::class, [
                    'inherit_data' => true,
                    'tabName' => 'ui.description',
                    'tabIcon' => 'flaticon-edit-1'
                ])
                    ->add('elements', DashboardCollectionType::class, [
                        'prototype_template' => '@News/dashboard/news/elements/form/_news_elements_prototype.html.twig',
                        'entry_type' => NewsElementType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'by_reference' => false,
                        'prototype_data' => new NewsElement(),
                    ])
            )
            ->add(
                $builder->create('tags', DashboardFormType::class, [
                    'inherit_data' => true,
                    'tabName' => 'tags',
                    'translation_domain' => 'NewsBundle',
                ])
                    ->add('tags', DashboardSelect2EntityType::class, [
                        'required' => false,
                        'multiple' => true,
                        'expanded' => false,
                        'divLg' => 'col-lg-12',
                        'label' => false,
                        'translation_domain' => 'NewsBundle',
                        'class' => NewsTag::class,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->getTagsForForm();
                        }
                    ])
            )
            ->add(
                $builder->create('galleryImages', DashboardFormType::class, [
                    'inherit_data' => true,
                    'tabName' => 'sidebar.photo_gallery.photo_gallery',
                    'tabIcon' => 'flaticon-web'
                ])
                    ->add('galleryImages', DashboardCollectionType::class, [
                        'prototype_template' => '@News/dashboard/news/gallery_images/form/_news_gallery_images_prototype.html.twig',
                        'entry_type' => NewsGalleryImageType::class,
                        'allow_add' => true,
                        'allow_delete' => true,
                        'prototype' => true,
                        'by_reference' => false,
                        'prototype_data' => new NewsGalleryImage(),
                    ])
            )
            ->addEventSubscriber(new AddSeoSubscriber())
            ->addEventSubscriber(new AddSaveBtnSubscriber($this->security));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => News::class, 'grantedRoles' => null]);
    }
}
