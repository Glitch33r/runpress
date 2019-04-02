<?php

namespace FrontendBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use IhorDrevetskyi\NewsBundle\Entity\News;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class DefaultController extends \IhorDrevetskyi\ComponentBundle\Controller\Frontend\DefaultController
{
    public function initNewsCategorySliderAction(EntityManagerInterface $em, string $slug, int $countInPage)
    {
        $news = $em->getRepository(News::class)
            ->getElementsByCategoryLimit($slug, $countInPage);

        return $this->render('news_category/_slider.html.twig', [
            'news' => $news,
        ]);
    }

    public function initNewsSliderAction(EntityManagerInterface $em, int $countInPage)
    {
        $news = $em->getRepository(News::class)
            ->getLimitElements($countInPage);

        return $this->render('news_category/_slider.html.twig', [
            'news' => $news,
        ]);
    }

    public function initSidebarNewsAction(EntityManagerInterface $em)
    {
        $news = $em->getRepository(News::class)->getLimitElements(10);

        return $this->render('news/_sidebar_news.html.twig', [
            'news' => $news,
        ]);
    }

    public function newsFeedAction(EntityManagerInterface $em, int $countInPage)
    {
        $newsFeed = $em->getRepository(News::class)->getLimitElements($countInPage);

        return $this->render('news/_newsFeed.html.twig', [
            'newsFeed' => $newsFeed,
        ]);
    }

    public function initSidebarBannerAction(EntityManagerInterface $em)
    {
//        $banners = $em->getRepository(Banner::class)->getByPage('homepage');

        return $this->render('default/_sidebar_banner.html.twig', [
//            'banners' => $banners,
        ]);
    }
}