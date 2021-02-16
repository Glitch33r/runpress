<?php

namespace BackendBundle\Controller\Dashboard;

use Symfony\Component\HttpFoundation\Response;
use SeoBundle\Controller\Dashboard\sidebarSeoBundleTrait;
use UserBundle\Controller\Dashboard\sidebarUserBundleTrait;
use NewsBundle\Controller\Dashboard\sidebarNewsBundleTrait;
use StaticBundle\Controller\Dashboard\sidebarStaticBundleTrait;
use BannerBundle\Controller\Dashboard\sidebarBannerBundleTrait;
use IhorDrevetskyi\SupportCenter\ContactBundle\Controller\Dashboard\sidebarContactBundleTrait;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class DashboardConfig extends \DashboardBundle\Controller\DashboardConfig
{
    /**
     * @return bool
     */
    public function isUseLogo(): bool
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function elementsForHorizontalMenu(): array
    {
        return [];
    }

    use sidebarContactBundleTrait;
    use sidebarNewsBundleTrait;
    use sidebarSeoBundleTrait;
    use sidebarStaticBundleTrait;
    use sidebarUserBundleTrait;
    use sidebarBannerBundleTrait;

    /**
     * @return Response
     */
    public function renderAsideMenuElements(): Response
    {
        $sidebar = [];

        $supportCenter = self::headingSidebar('', 'sidebar.support_center', [
            self::contactBundleRoles()['contact'], self::contactBundleRoles()['status'],
            self::contactBundleRoles()['manager'], self::contactBundleRoles()['setting']['mail']
        ], []);

        if (!is_null($supportCenter)) {
            $contact = self::sidebarContactBundle();
            (!is_null($contact)) ? $supportCenter['items'][] = $contact : null;
        }

        // $general = self::headingSidebar('', 'ui.general_info', [
        //     'ROLE_DIRECTOR'
        // ], []);

        // if (!is_null($general)) {
        //     $info = self::itemSidebar(['ROLE_DIRECTOR'], ['info/edit'], [
        //         'dashboard_info_index', 'dashboard_info_new'
        //     ], 'flaticon-notes', false, null, null, 'Инфографика', [],
        //         'dashboard_info_index');
        //     (!is_null($info)) ? $general['items'][] = $info : null;

        //     $opinion = self::itemSidebar(['ROLE_DIRECTOR'], ['opinion/edit'], [
        //         'dashboard_opinion_index', 'dashboard_opinion_new'
        //     ], 'flaticon-notes', false, null, null, 'Мнения', [],
        //         'dashboard_opinion_index');
        //     (!is_null($opinion)) ? $general['items'][] = $opinion : null;

        //     $sidebar['general_info'] = $general;
        // }

        $news = self::sidebarNewsBundle();
        (!is_null($news)) ? $sidebar['news'] = $news : null;

        $settings = self::headingSidebar('', 'sidebar.configuration.configuration', [
            self::seoBundleRoles()['seo'], self::staticBundleRoles()['static_page']
//            'ROLE_LOG'
        ], []);

        if (!is_null($settings)) {
            $seo = self::sidebarSeoBundle();
            (!is_null($seo)) ? $settings['items'][] = $seo : null;
            $static = self::sidebarStaticBundle();
            (!is_null($static)) ? $settings['items'][] = $static : null;
            $user = self::sidebarUserBundle();
            (!is_null($user)) ? $settings['items'][] = $user : null;
            $banner = self::sidebarBannerBundle();
            (!is_null($banner)) ? $settings['items'][] = $banner : null;

            $documents = self::itemSidebar(['ROLE_DIRECTOR'], ['documents/edit'], [
                'dashboard_documents_index', 'dashboard_documents_new'
            ], 'flaticon-notes', false, null, null, 'Документы', [],
                'dashboard_documents_index');
            (!is_null($documents)) ? $settings['items'][] = $documents : null;

            $info = self::itemSidebar(['ROLE_DIRECTOR'], ['info/edit'], [
                'dashboard_info_index', 'dashboard_info_new'
            ], 'flaticon-notes', false, null, null, 'Инфографика', [],
                'dashboard_info_index');
            (!is_null($info)) ? $general['items'][] = $info : null;
                
            $sidebar['settings'] = $settings;
        }


        return $this->render('@Dashboard/templates/' . self::getTemplateNumber() . '/aside/aside_menu/_element.html.twig', [
            'sidebar' => $sidebar,
            'request' => $this->request
        ]);
    }

    /**
     * @return bool
     */
    public function isUseRenderTopBar(): bool
    {
        return true;
    }

    public static function getRoles(): array
    {
        return [
            'Главные роли' => [
                'Разработчик' => 'ROLE_DEVELOPER',
                'Директор' => 'ROLE_DIRECTOR',
                'Пользователи' => 'ROLE_USER',
                'Журналист' => 'ROLE_JOURNALIST',
            ]
        ];
    }

    /**
     * @return Response
     */
    public function renderFooterSupportCenter(): Response
    {
        return new Response('');
    }

    /**
     * @return Response
     */
    public function renderFooterCopyRight(): Response
    {
        return new Response('');
    }
}