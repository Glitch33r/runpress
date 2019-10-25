<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Info;
use BackendBundle\Entity\Opinion;
use BackendBundle\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use FrontendBundle\Entity\WpPostmeta;
use FrontendBundle\Entity\WpPosts;
use FrontendBundle\Entity\WpTermRelationships;
use FrontendBundle\Entity\WpTerms;
use FrontendBundle\Entity\WpTermTaxonomy;
use NewsBundle\Entity\News;
use NewsBundle\Entity\NewsCategory;
use NewsBundle\Entity\NewsCategoryTranslation;
use NewsBundle\Entity\NewsTranslation;
use SeoBundle\Entity\Seo;
use SeoBundle\Utils\SeoManager;
use UploadBundle\Services\FileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class HomepageController extends AbstractController
{
    public function save(EntityManagerInterface $em, FileHandler $fileHandler)
    {
        $WpTermTaxonomy = $em->getRepository(WpTermTaxonomy::class)->findBy([
            'taxonomy' => 'category'
        ]);

        foreach ($WpTermTaxonomy as $taxonomy) {
            $category = $em->getRepository(WpTerms::class)->findOneBy([
                'termId' => $taxonomy->getTermId()
            ]);
            if (!empty($category)) {
                $newsCategoryT = $em->getRepository(NewsCategoryTranslation::class)->findOneBy(['title' => trim($category->getName())]);
                if (!empty($newsCategoryT)) {
                    $newsCategory = $newsCategoryT->getTranslatable();
                } else {
                    $newsCategory = new NewsCategory();
                    $newsCategory->setOldSlug($category->getSlug());
                    $newsCategorySeo = new Seo();
                    $newsCategorySeo->translate('ru')->setMetaTitle(trim($category->getName()));
                    $newsCategorySeo->translate('ru')->setH1(trim($category->getName()));
                    $newsCategorySeo->translate('ru')->setBreadcrumb(trim($category->getName()));
                    $newsCategorySeo->mergeNewTranslations();
                    $em->persist($newsCategorySeo);
                    $newsCategory->setSeo($newsCategorySeo);
                    $newsCategory->translate('ru')->setTitle(trim($category->getName()));
                    $newsCategory->mergeNewTranslations();
                    $em->persist($newsCategory);
                }

                $WpTermRelationships = $em->getRepository(WpTermRelationships::class)->findBy([
                    'termTaxonomyId' => $category->getTermId()
                ]);
                foreach ($WpTermRelationships as $item) {
                    $post = $em->getRepository(WpPosts::class)->findOneBy([
                        'id' => $item->getObjectId(),
                        'postStatus' => 'publish'
                    ]);
                    if (!empty($post)) {
                        $newsT = $em->getRepository(NewsTranslation::class)->findOneBy(
                            ['title' => trim($post->getPostTitle())]);
                        if (!empty($newsT)) {
                            $news = $newsT->getTranslatable();
                        } else {
                            $news = new News();
                            $news->setOldSlug(urldecode($post->getPostName()));
                            $seo = new Seo();
                            $seo->translate('ru')->setMetaTitle(trim($post->getPostTitle()));
                            $seo->translate('ru')->setH1(trim($post->getPostTitle()));
                            $seo->translate('ru')->setBreadcrumb(trim($post->getPostTitle()));
                            $seo->mergeNewTranslations();
                            $em->persist($seo);
                            $news->setSeo($seo);
                            $news->setNewsCategory($newsCategory);
                            $news->translate('ru')->setTitle(trim($post->getPostTitle()));
                            $news->translate('ru')->setDescription($post->getPostContent());
                            $news->translate('ru')->setShortDescription($post->getPostExcerpt());
                            $news->setPublishAt($post->getPostDate());
                            $news->mergeNewTranslations();
                            $em->persist($news);
                            $em->flush();
                        }
                        $posts = $em->getRepository(WpPosts::class)->findBy([
                            'postParent' => $post->getId()
                        ]);
                        if ($posts) {
                            foreach ($posts as $postsItem) {
                                $WpPostmeta = $em->getRepository(WpPostmeta::class)->findOneBy([
                                    'metaKey' => '_wp_attached_file',
                                    'postId' => $postsItem->getId()
                                ]);
                                if (!empty($WpPostmeta)) {
                                    $image = $WpPostmeta->getMetaValue();
                                    try {
                                        if (!empty($image) and empty($news->getPoster())) {
                                            $subDir = '/' . $news->getId();
                                            $filePath['file_type'] = 'news_poster';
                                            $filePath['field'] = 'image';
                                            $filePath['path'] = '/temp/1/uploads/' . $image;
                                            if (file_exists('E:\OSPanel\symfony\ranpress\public' . $filePath['path']) and
                                                strripos($filePath['path'], '.pdf') === false and
                                                strripos($filePath['path'], '.html') === false and
                                                strripos($filePath['path'], '.mp4') === false and
                                                strripos($filePath['path'], '.docx') === false and
                                                strripos($filePath['path'], '.doc') === false and
                                                strripos($filePath['path'], '.xlsx') === false and
                                                strripos($filePath['path'], '.mp3') === false
                                            ) {
                                                $resultRes = $fileHandler->handleFileAndSave($filePath, $subDir, false);
                                                if (!empty($resultRes)) {
                                                    $news->setPoster(json_encode($resultRes));
                                                    $em->persist($news);
                                                    $em->remove($post);
                                                    $em->remove($postsItem);
                                                    $em->remove($WpPostmeta);
                                                    $em->flush();
                                                }
                                            }
                                        }
                                    } catch (\Exception $exception) {
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function indexAction(
        EntityManagerInterface $em, SeoManager $seoManager,
        FileHandler $fileHandler, $news = null)
    {

//        self::save($em, $fileHandler);
//        dump('d');
//        die;
        if (!is_null($news)) {
            $news = $em->getRepository(News::class)->getElementBySlug($news);

            if (!empty($news)) {
                $newsDefaultLocale = $news->getDefaultLocale();
                $newsCategory = $news->getNewsCategory();

                if (!empty($newsCategory)) {
                    $newsCategoryDefaultLocale = $newsCategory->getDefaultLocale();

                    return $this->redirectToRoute('frontend_news_show', [
                        'slug' => $news->translate($newsDefaultLocale)->getSlug(),
                        'category' => $newsCategory->translate($newsCategoryDefaultLocale)->getSlug()
                    ]);
                }

                return $this->redirectToRoute('frontend_news_show', [
                    'slug' => $news->translate($newsDefaultLocale)->getSlug(),
                ]);
            }
        }

        $newsSlider = $em->getRepository(News::class)->getLimitForSliderElements(6);
        $newsRAND = $em->getRepository(News::class)->getLimitRANDElements(2);
        $video = $em->getRepository(Video::class)->getLimitElements(2);
        $opinion = [];//$em->getRepository(Opinion::class)->getLimitElements(2);
        $info = [];//$em->getRepository(Info::class)->getLimitElements(4);
        $asideCategories = $em->getRepository(NewsCategory::class)->getAsideElementsOnMain();

        return $this->render('homepage/index.html.twig', [
            'seo' => $seoManager->getSeoForHomePage(),
            'newsRAND' => $newsRAND,
            'newsSlider' => $newsSlider,
            'video' => $video,
            'opinion' => $opinion,
            'info' => $info,
            'asideCategories' => $asideCategories,
        ]);
    }
}
