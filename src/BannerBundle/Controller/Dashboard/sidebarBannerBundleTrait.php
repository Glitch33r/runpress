<?php

namespace BannerBundle\Controller\Dashboard;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait sidebarBannerBundleTrait
{
    /**
     * @return array
     */
    private function bannerBundlePathForEdit(): array
    {
        return [
            'banner' => 'banner/edit',
        ];
    }

    /**
     * @return array
     */
    private function bannerBundleRouteName(): array
    {
        return [
            'banner' => [
                'index' => 'dashboard_banner_index', 'new' => 'dashboard_banner_new',
            ],
        ];
    }

    /**
     * @return array
     */
    private function bannerBundleRoles(): array
    {
        return [
            'banner' => 'ROLE_BANNER_CREATE_EDIT',
        ];
    }

    /**
     * @return array|null
     */
    private function sidebarBannerBundle(): ?array
    {
        return self::itemSidebar(
            [
                self::bannerBundleRoles()['banner']
            ], [
                self::bannerBundlePathForEdit()['banner']
            ], [
                self::bannerBundleRouteName()['banner']['index'],
                self::bannerBundleRouteName()['banner']['new']
            ],
            'flaticon-notes', false, null, null,
            'Банеры', [],
            self::bannerBundleRouteName()['banner']['index']
        );

//        $banner = self::headingSidebar('', 'sidebar.news.news', [
//            self::bannerBundleRoles()['banner']
//        ], [], 'NewsBundle');
//
//        if (!is_null($banner)) {
//
//            $bn = self::itemSidebar([
//                self::bannerBundleRoles()['banner']
//            ], [
//                self::bannerBundlePathForEdit()['banner']
//            ], [
//                self::bannerBundleRouteName()['banner']['index'],
//                self::bannerBundleRouteName()['banner']['new']
//            ],
//                'flaticon-map', false, null, null,
//                'sidebar.news.categories', [],
//                self::bannerBundleRouteName()['banner']['index'], 'NewsBundle'
//            );
//            (!is_null($bn)) ? $banner['items'][] = $bn : null;
//
//            return $banner;
//        }
//
//        return null;
    }
}
