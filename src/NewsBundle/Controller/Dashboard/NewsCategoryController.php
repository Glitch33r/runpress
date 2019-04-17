<?php

namespace NewsBundle\Controller\Dashboard;

use Twig\Environment;
use SeoBundle\Entity\Seo;
use NewsBundle\Entity\NewsCategory;
use Doctrine\ORM\EntityManagerInterface;
use DashboardBundle\Controller\CRUDController;
use NewsBundle\Form\Type\Dashboard\NewsCategoryType;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class NewsCategoryController extends CRUDController
{
    /**
     * @return array
     */
    public function getGrantedRoles(): array
    {
        return [
            'index' => 'ROLE_NEWS_CATEGORY_LIST', 'new' => 'ROLE_NEWS_CATEGORY_CREATE',
            'edit' => 'ROLE_NEWS_CATEGORY_EDIT', 'delete' => 'ROLE_NEWS_CATEGORY_DELETE',
        ];
    }

    /**
     * @return array
     */
    public function getRouteElements(): array
    {
        return [
            'index' => 'dashboard_news_category_index', 'new' => 'dashboard_news_category_new',
            'edit' => 'dashboard_news_category_edit', 'delete' => 'dashboard_news_category_delete',
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
            'order_column' => 'position',
            'order_by' => "asc"
        ];
    }

    /**
     * @return string
     */
    public function getHeadTitle(): string
    {
        return
            $this->translator->trans('sidebar.news.news', [], 'NewsBundle')
            . ' > ' .
            $this->translator->trans('sidebar.news.categories', [], 'NewsBundle');
    }

    /**
     * @return array
     */
    public function getPortletHeadIcon(): array
    {
        return [
            'useSvg' => true,
            'icon' => 'flaticon-map',
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect id="bound" x="0" y="0" width="24" height="24"/>
        <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" id="Combined-Shape" fill="#000000"/>
        <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
    </g>
</svg>'
        ];
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository|mixed|\NewsBundle\Entity\Repository\NewsCategoryRepository
     */
    public function getRepository(EntityManagerInterface $em)
    {
        return $em->getRepository(NewsCategory::class);
    }

    /**
     * @return array
     */
    public function getListElementsForIndexDashboard(TranslatorInterface $translator): array
    {
        return [
            'translations-title' => $this->translator->trans('ui.title', [], 'DashboardBundle'),
            'position' => $this->translator->trans('ui.position', [], 'DashboardBundle'),
            'showOnWebsite' => $this->translator->trans('ui.show_on_website', [], 'DashboardBundle'),
            'showInMenu' => $this->translator->trans('ui.show_in_menu', [], 'DashboardBundle'),
            'showOnMainPage' => $this->translator->trans('ui.show_on_main_page', [], 'DashboardBundle')
        ];
    }

    /**
     * @param $item
     * @return array
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function createDataForList($item, Environment $twig): array
    {
        return [
            'translations-title' => $item->translate()->getTitle(),
            'position' => $item->getPosition(),
            'showOnWebsite' => $this->twig->render('@Dashboard/default/crud/list/element/_yes_no.html.twig', [
                'element' => $item->getShowOnWebsite(),
            ]),
            'showInMenu' => $this->twig->render('@Dashboard/default/crud/list/element/_yes_no.html.twig', [
                'element' => $item->getShowInMenu(),
            ]),
            'showOnMainPage' => $this->twig->render('@Dashboard/default/crud/list/element/_yes_no.html.twig', [
                'element' => $item->getShowOnMainPage(),
            ]),
        ];
    }

    /**
     * @return string
     */
    public function getFormType(): string
    {
        return NewsCategoryType::class;
    }

    /**
     * @return NewsCategory
     */
    public function getFormElement()
    {
        $seo = new Seo();
        $newCategory = new NewsCategory();
        $newCategory->setSeo($seo);

        return $newCategory;
    }
}