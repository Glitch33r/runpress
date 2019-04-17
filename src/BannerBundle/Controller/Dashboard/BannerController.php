<?php

namespace BannerBundle\Controller\Dashboard;

use Symfony\Contracts\Translation\TranslatorInterface;
use BannerBundle\Form\Type\Dashboard\BannerType;
use BannerBundle\Entity\Banner;
use Twig\Environment;
use DashboardBundle\Controller\CRUDController;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class BannerController extends CRUDController
{
    private static $pages = [];

    /**
     * @return array
     */
    public function getGrantedRoles(): array
    {
        return [
            'index' => 'ROLE_BANNER_LIST', 'new' => 'ROLE_BANNER_CREATE',
            'edit' => 'ROLE_BANNER_EDIT', 'delete' => 'ROLE_BANNER_DELETE',
        ];
    }

    /**
     * @return array
     */
    public function getRouteElements(): array
    {
        return [
            'index' => 'dashboard_banner_index', 'new' => 'dashboard_banner_new',
            'edit' => 'dashboard_banner_edit', 'delete' => 'dashboard_banner_delete',
        ];
    }

    /**
     * @return array
     */
    public function getConfigForIndexDashboard(): array
    {
        return [
            'pageLength' => 25,
            'lengthMenu' => '10, 20, 25, 50, 100, 150',
            'order_column' => 'publishAt',
            'order_by' => "desc"
        ];
    }

    /**
     * @return string
     */
    public function getHeadTitle(): string
    {
        return 'Банеры';
    }

    /**
     * @return array
     */
    public function getPortletHeadIcon(): array
    {
        return ['icon'=>'flaticon-notes'];
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|\NewsBundle\Entity\Repository\NewsRepository
     */
    public function getRepository(EntityManagerInterface $em)
    {
        return $em->getRepository(Banner::class);
    }

    /**
     * @return array
     */
    public function getListElementsForIndexDashboard(TranslatorInterface $translator): array
    {
        return [
            'type' => $this->translator->trans('ui.type', [], 'DashboardBundle'),
            'page' => $this->translator->trans('ui.page', [], 'DashboardBundle'),
            'img' => $this->translator->trans('ui.image', [], 'DashboardBundle'),
            'link' => $this->translator->trans('ui.link', [], 'DashboardBundle'),
            'showOnWebsite' => $this->translator->trans('ui.show_on_website', [], 'DashboardBundle'),
            'createdAt' => [
                'locked' => true,
                'title' => $this->translator->trans('ui.date', [], 'DashboardBundle'),
            ]
        ];
    }

    /**
     * @param $item
     * @return array
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function createDataForList($item, Environment $twig): array
    {
        return [
            'type' => $this->translator->trans('ui.banner_positions.' . $item->getType(), [], 'DashboardBundle'),
            'page' => $this->translator->trans('ui.site_pages.' . $item->getPage(), [], 'DashboardBundle'),
            'img' => $this->twig->render('@Dashboard/default/crud/list/element/_img.html.twig', [
                'element' => $item->getImg()
            ]),
            'link' => $item->getLink(),
            'showOnWebsite' => $this->twig->render('@Dashboard/default/crud/list/element/_yes_no.html.twig', [
                'element' => $item->getShowOnWebsite()
            ]),
            'createdAt' => $this->twig->render('@Dashboard/default/crud/list/element/_data.html.twig', [
                'element' => $item->getCreatedAt()
            ])
        ];
    }


    public function getFormType(): string
    {
        return BannerType::class;
    }

    public function getFormElement()
    {
        $new = new Banner();

        return $new;
    }
}