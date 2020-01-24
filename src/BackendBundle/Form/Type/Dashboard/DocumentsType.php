<?php

namespace BackendBundle\Form\Type\Dashboard;

use BackendBundle\Entity\Area;
use BackendBundle\Entity\Currency;
use BackendBundle\Entity\CurrencyAuction;
use BackendBundle\Entity\Documents;
use DashboardBundle\Form\Type\Dashboard\DashboardDescriptionType;
use SeoBundle\Form\Type\Dashboard\SeoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DashboardBundle\Form\Type\AddSaveBtnSubscriber;
use DashboardBundle\Form\Type\DashboardTranslationsType;
use DashboardBundle\Form\Type\DashboardTextareaType;
use DashboardBundle\Form\Type\DashboardYesNoType;
use DashboardBundle\Form\Type\DashboardPositionType;
use DashboardBundle\Form\Type\DashboardTextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use DashboardBundle\Form\Type\Dashboard\DashboardSelect2EntityType;
use UploadBundle\Form\Type\UploadType;
use Symfony\Component\Security\Core\Security;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class DocumentsType extends AbstractType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', DashboardTranslationsType::class, [
                'label' => false,
                'fields' => [
                    'title' => [
                        'label' => 'Название',
                        'field_type' => DashboardTextType::class,
                        'helpBlock' => null,
                        'maxLength' => 255,
                        'disabled' => false
                    ],
                ]
            ])
            // ->add('position', DashboardPositionType::class, [
            //     'label' => 'ui.position',
            //     // 'up_color' => 'red',
            //     // 'down_color' => 'green',
            // ])
            ->add('showOnWebsite', DashboardYesNoType::class, [
                'label' => 'ui.show_on_website',
                'translation_domain' => 'DashboardBundle',
            ])
            ->add('document', UploadType::class, [
                'file_type' => 'documents',
                'extensions' => '.pdf, .doc, .docx, .txt',
                'label' => 'Файл',
                'required' => false,
            ]);

        $builder
            ->addEventSubscriber(new AddSaveBtnSubscriber($this->security));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Documents::class, 'grantedRoles' => null]);
    }
}