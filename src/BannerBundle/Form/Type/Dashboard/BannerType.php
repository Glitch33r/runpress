<?php

namespace BannerBundle\Form\Type\Dashboard;

use BannerBundle\Entity\Banner;
use DashboardBundle\Form\Type\AddSaveBtnSubscriber;
use DashboardBundle\Form\Type\DashboardChoiceType;
use DashboardBundle\Form\Type\DashboardUrlType;
use DashboardBundle\Form\Type\DashboardYesNoType;
use SeoBundle\Form\Type\Dashboard\AddSeoSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use UploadBundle\Form\Type\UploadType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Design studio origami <https://origami.ua>
 */
class BannerType extends AbstractType
{
    /**
     * @var Security
     */
    protected $security;

    /**
     * StaticContentType constructor.
     *
     * @param Security $security
     */
    public function __construct(Security $security, TranslatorInterface $translator)
    {
        $this->security = $security;
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', DashboardChoiceType::class, [
                'label' => 'ui.type',
                'choices' => [
                    $this->translator->trans('ui.banner_positions.upper_page', [], 'DashboardBundle') => 'upper_page',
                    $this->translator->trans('ui.banner_positions.aside_page', [], 'DashboardBundle') => 'aside_page',
                    $this->translator->trans('ui.banner_positions.bottom_page', [], 'DashboardBundle') => 'bottom_page',
                ],
                'required' => true,
                'translation_domain' => 'DashboardBundle',
            ])
            ->add('page', DashboardChoiceType::class, [
                'label' => 'ui.page',
                'choices' => [
                    $this->translator->trans('ui.site_pages.main', [], 'DashboardBundle') => 'main',
                    $this->translator->trans('ui.site_pages.news_feed', [], 'DashboardBundle') => 'news_feed',
                    $this->translator->trans('ui.site_pages.news_item', [], 'DashboardBundle') => 'news_item',
                    $this->translator->trans('ui.site_pages.contacts', [], 'DashboardBundle') => 'contacts',
                ],
                'required' => true,
                'translation_domain' => 'DashboardBundle',
            ])
            ->add('link', DashboardUrlType::class, [
                'label' => 'ui.link',
                'required' => false,
                'translation_domain' => 'DashboardBundle',
            ])
            ->add('img', UploadType::class, [
                'file_type' => 'banner_image',
                'extensions' => '.jpg, .gif, .png, .svg',
                'label' => 'ui.image',
                'translation_domain' => 'DashboardBundle',
                'required' => false,
            ])
            ->add('showOnWebsite', DashboardYesNoType::class, [
                'label' => 'ui.show_on_website',
                'required' => false,
                'translation_domain' => 'DashboardBundle',
                'divLg' => 'col-lg-6',
                'labelLg' => 'col-lg-6',
            ])
            ->addEventSubscriber(new AddSaveBtnSubscriber($this->security));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Banner::class, 'grantedRoles' => null]);
    }
}
