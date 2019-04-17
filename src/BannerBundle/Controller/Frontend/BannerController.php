<?php

namespace BannerBundle\Controller\Frontend;

use BannerBundle\Entity\Banner;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class BannerController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\BannerBundle\Entity\Repository\BannerRepository
     */
    private $bannerRepository;

    /**
     * HomepageController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->bannerRepository = $this->em->getRepository(Banner::class);
    }

   public function getUpperPageBannerAction()
   {
        $banner = $this->bannerRepository->getRandomBannerByType('upper_page');

        return $this->render('banner/_upper_page.html.twig',[
            'banner' => $banner
        ]);
   }

   public function getNewsListPageBannerAction()
   {
        $banner = $this->bannerRepository->getRandomBannerByType('news_list_page');

        return $this->render('banner/_news_list_page.html.twig',[
            'banner' => $banner
        ]);
   }

   public function getAsidePageBannerAction()
   {
       $banner = $this->bannerRepository->getRandomBannerByType('aside_page');

       return $this->render('banner/_aside_page.html.twig',[
           'banner' => $banner
       ]);
   }

   public function getBannerAction(string $type, string $page)
   {
       $banner = $this->bannerRepository->getOneBannerByTypeForPage($type, $page);

       return $this->render('banner/' . $type . '.html.twig',[
           'banner' => $banner
       ]);
   }
}