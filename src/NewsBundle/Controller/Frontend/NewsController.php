<?php

namespace NewsBundle\Controller\Frontend;

use NewsBundle\Entity\News;
use SeoBundle\Utils\SeoManager;
use NewsBundle\Entity\NewsCategory;
use Doctrine\ORM\EntityManagerInterface;
use NewsBundle\Entity\NewsAuthorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ComponentBundle\Utils\BreadcrumbsGenerator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class NewsController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\NewsBundle\Entity\Repository\NewsRepository
     */
    private $newsRepository;

    /**
     * @var BreadcrumbsGenerator
     */
    private $breadcrumbsGenerator;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var SeoManager
     */
    private $seoManager;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * NewsController constructor.
     * @param EntityManagerInterface $em
     * @param BreadcrumbsGenerator $breadcrumbsGenerator
     * @param TranslatorInterface $translator
     * @param SeoManager $seoManager
     * @param PaginatorInterface $paginator
     */
    public function __construct(
        EntityManagerInterface $em, BreadcrumbsGenerator $breadcrumbsGenerator, TranslatorInterface $translator,
        SeoManager $seoManager, PaginatorInterface $paginator
    )
    {
        $this->em = $em;
        $this->paginator = $paginator;
        $this->translator = $translator;
        $this->seoManager = $seoManager;
        $this->breadcrumbsGenerator = $breadcrumbsGenerator;
        $this->newsRepository = $this->em->getRepository(News::class);
    }

    /**
     * @param int|null $page
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function helperForindexAction(int $page = null)
    {
        $breadcrumbsArr = $this->breadcrumbsGenerator->getBreadcrumbForHomePage();
        $seo = $this->seoManager->getSeoForPage('news');

        if ($page > 1) {
            $seo->h1 = $seo->h1 . ' - №' . $page;
            $seo->title = $seo->title . ' - №' . $page;
        }

        $breadcrumbsArr['frontend_news_list'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $parameters = [
            'seo' => $seo,
            'breadcrumbs' => $this->breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr),
        ];

        return $parameters;
    }

    /**
     * @param Request $request
     * @param NewsCategory $category
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     * @throws \Exception
     */
    private function helperForGetElementsByCategoryWithStandardPaginationAction(
        Request $request, NewsCategory $category, int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        if (!is_null($month) and !is_null($year)) {
//            $news = $this->newsRepository->getQueryElementsByInterval($month, $year);
//            $elements = $paginator->paginate($news, $request->query->getInt('page', $page), $countInPage);
//            $elements->setTemplate('news/_pagination_by_interval.html.twig');
//            $elements->setUsedRoute('frontend_partial_get_news_elements_by_interval');
//            $elements->setParam('month', $month);
//            $elements->setParam('year', $year);
        } else {
            $elements = $this->paginator->paginate(
                $this->newsRepository->getQueryForElementsByCategory($category),
                $request->query->getInt('page', $page), $countInPage
            );
            $elements->setTemplate('news_category/_pagination_with_standard_pagination.html.twig');
            $elements->setUsedRoute('frontend_news_category_show');
        }

        $elements->setParam('countInPage', $countInPage);
        $elements->setParam('category', $category->translate($category->getDefaultLocale())->getSlug());


        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $this->translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    /**
     * @param Request $request
     * @param NewsCategory $category
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @return Response
     * @throws \Exception
     */
    public function getNewsElementsByCategoryWithStandardPaginationAction(
        Request $request, NewsCategory $category, int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        $elements = self::helperForGetElementsByCategoryWithStandardPaginationAction(
            $request, $category, $page, $countInPage, $month, $year
        );

        $parameters = [
            'elements' => $elements,
            'isKnpPaginationRender' => true
        ];

        return $this->render(
            'news_category/_news_paginated_elements_with_standard_pagination.html.twig', $parameters
        );
    }

    /**
     * @param Request $request
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     * @throws \Exception
     */
    private function helperForGetElementsWithStandardPaginationAction(
        Request $request, int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        if (!is_null($month) and !is_null($year)) {
//            $news = $this->newsRepository->getQueryElementsByInterval($month, $year);
//            $elements = $paginator->paginate($news, $request->query->getInt('page', $page), $countInPage);
//            $elements->setTemplate('news/_pagination_by_interval.html.twig');
//            $elements->setUsedRoute('frontend_partial_get_news_elements_by_interval');
//            $elements->setParam('month', $month);
//            $elements->setParam('year', $year);
        } else {
            $elements = $this->paginator->paginate(
                $this->newsRepository->getQueryForLimitElements(null),
                $request->query->getInt('page', $page), $countInPage
            );
            $elements->setTemplate('news/_pagination_with_standard_pagination.html.twig');
            $elements->setUsedRoute('frontend_news_list');
        }

        $elements->setParam('countInPage', $countInPage);

        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $this->translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    /**
     * @param Request $request
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @return Response
     * @throws \Exception
     */
    public function getNewsElementsWithStandardPaginationAction(
        Request $request, int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        $elements = self::helperForGetElementsWithStandardPaginationAction(
            $request, $page, $countInPage, $month, $year
        );

        $parameters = [
            'elements' => $elements,
            'isKnpPaginationRender' => true
        ];

        return $this->render('news/_news_paginated_elements_with_standard_pagination.html.twig', $parameters);
    }

    /**
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function indexWithStandardPaginationAction(
        int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        $parameters = self::helperForindexAction($page);
        $parameters['page'] = $page;
        $parameters['countInPage'] = $countInPage;

        return $this->render('news/index.html.twig', $parameters);
    }

    /**
     * @param SeoManager $seoManager
     * @param BreadcrumbsGenerator $breadcrumbsGenerator
     * @return mixed
     * @throws \Exception
     */
    public function indexWithAjaxPaginationAction()
    {
        return $this->render('news/index.html.twig', self::helperForindexAction());
    }

    /**
     * @param Request $request
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @return mixed
     * @throws \Exception
     */
    private function helperForGetElementsInIndexAction(
        Request $request, int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        if (!is_null($month) and !is_null($year)) {
//            $news = $this->newsRepository->getQueryElementsByInterval($month, $year);
//            $elements = $paginator->paginate($news, $request->query->getInt('page', $page), $countInPage);
//            $elements->setTemplate('news/_pagination_by_interval.html.twig');
//            $elements->setUsedRoute('frontend_partial_get_news_elements_by_interval');
//            $elements->setParam('month', $month);
//            $elements->setParam('year', $year);
        } else {
            $news = $this->newsRepository->getQueryForLimitElements(null);
            $elements = $this->paginator->paginate(
                $news, $request->query->getInt('page', $page), $countInPage
            );
            $elements->setTemplate('news/_pagination.html.twig');
            $elements->setUsedRoute('frontend_partial_get_news_elements');
        }

        $elements->setParam('countInPage', $countInPage);

        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $this->translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    /**
     * @param Request $request
     * @param int $page
     * @param int $countInPage
     * @param int|null $month
     * @param int|null $year
     * @param bool $fromTwig
     * @return Response
     * @throws \Exception
     */
    public function getNewsElementsAction(
        Request $request, int $page, int $countInPage, int $month = null, int $year = null, bool $fromTwig = false
    )
    {
        $elements = self::helperForGetElementsInIndexAction(
            $request, $page, $countInPage, $month, $year
        );

        $parameters = [
            'elements' => $elements,
            'isKnpPaginationRender' => !($page == $elements->getPageCount())
        ];

        if ($fromTwig or $request->isXmlHttpRequest()) {
            return $this->render('news/_paginated_elements.html.twig', $parameters);
        } else {
            $response = new Response(Response::HTTP_OK);

            $response->headers->set('X-Robots-Tag', 'noindex');

            return $this->render('news/paginated_elements.html.twig', $parameters, $response);
        }
    }

    private function helperForGetElementsByCategory(
        Request $request, string $category, int $page, int $countInPage, int $month = null, int $year = null
    )
    {
        if (!is_null($month) and !is_null($year)) {
//            $news = $this->newsRepository->getElementsByCategoryAndInterval($category, $month, $year);
//            $elements = $paginator->paginate($news, $request->query->getInt('page', $page), $countInPage);
//            $elements->setTemplate('news_category/_pagination_by_interval.html.twig');
//            $elements->setUsedRoute('frontend_partial_get_news_elements_by_category_and_interval');
//            $elements->setParam('month', $month);
//            $elements->setParam('year', $year);
        } else {
            $news = $this->newsRepository->getElementsByCategorySlug($category);
            $elements = $this->paginator->paginate($news, $request->query->getInt('page', $page), $countInPage);
            $elements->setTemplate('news_category/_pagination.html.twig');
            $elements->setUsedRoute('frontend_partial_get_news_elements_by_category');
        }

        $elements->setParam('category', $category);
        $elements->setParam('countInPage', $countInPage);

        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $this->translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    public function getNewsElementsByCategoryAction(
        Request $request, string $category, int $page, int $countInPage,
        int $month = null, int $year = null, bool $fromTwig = false
    )
    {
        $elements = $this->helperForGetElementsByCategory(
            $request, $category, $page, $countInPage, $month, $year
        );

        $parameters = [
            'elements' => $elements,
            'isKnpPaginationRender' => !($page == $elements->getPageCount())
        ];

        if ($fromTwig or $request->isXmlHttpRequest()) {
            return $this->render('news_category/_paginated_elements.html.twig', $parameters);
        } else {
            $response = new Response(Response::HTTP_OK);

            $response->headers->set('X-Robots-Tag', 'noindex');

            return $this->render('news_category/paginated_elements.html.twig', $parameters, $response);
        }
    }

    /**
     * @param string $slug
     * @param string|null $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function showAction(
        BreadcrumbsGenerator $breadcrumbsGenerator, EntityManagerInterface $em,
        TranslatorInterface $translator, SeoManager $seoManager, string $slug, string $category = null
    )
    {
        $element = $em->getRepository(News::class)
            ->getElementBySlugAndCategory($slug, $category);

        if (!$element) {
            throw $this
                ->createNotFoundException(
                    $translator->trans('ui.notFound', [], 'DashboardBundle')
                );
        }

        $defaultLocale = $element->getDefaultLocale();
        $elementSlug = $element->translate($defaultLocale)->getSlug();

        if (
            !is_null($element->getOldSlug()) and
            $element->getOldSlug() != $elementSlug and
            $element->getOldSlug() == $slug
        ) {
            return $this->redirectToRoute('frontend_news_show', [
                'slug' => $elementSlug
            ]);
        }

        $breadcrumbsArr = $breadcrumbsGenerator->getBreadcrumbForHomePage();
        $seo = $seoManager->getSeoForPage('news');
        $breadcrumbsArr['frontend_news_list'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $seo = $element->getSeo()->getSeoForPage();
        $newsCategory = $element->getNewsCategory();

        if (!is_null($newsCategory)) {
            $newsCategorySeo = $newsCategory->getSeo()->getSeoForPage();
            $defaultCategoryLocale = $newsCategory->getDefaultLocale();
            $newsCategorySlug = $newsCategory->translate($defaultCategoryLocale)->getSlug();

            if (
                is_null($category) or
                (
                    !is_null($newsCategory->getOldSlug()) and
                    $newsCategory->getOldSlug() != $newsCategorySlug and
                    !is_null($category) and $newsCategory->getOldSlug() == $category
                )
            ) {
                return $this->redirectToRoute('frontend_news_show_with_category', [
                    'slug' => $elementSlug,
                    'category' => $newsCategorySlug
                ]);
            }

            $breadcrumbsArr['frontend_news_category_show'][] = [
                'parameters' => [
                    'category' => $newsCategorySlug
                ],
                'title' => (!empty($newsCategorySeo) and !empty($newsCategorySeo->breadcrumb)) ? $newsCategorySeo->breadcrumb : ''
            ];

            $breadcrumbsArr['frontend_news_show_with_category'][] = [
                'parameters' => [
                    'slug' => $elementSlug,
                    'category' => $newsCategorySlug
                ],
                'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
            ];
        } else {
            $breadcrumbsArr['frontend_news_show'][] = [
                'parameters' => [
                    'slug' => $elementSlug
                ],
                'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
            ];
        }

        $parameters = [
            'seo' => $seo,
            'element' => $element,
            'breadcrumbs' => $breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr)
        ];

        return $this->render('news/show.html.twig', $parameters);
    }

    /**
     * @param Request $request
     * @param NewsCategory $category
     * @param int $countInPage
     * @param News $news
     * @return Response
     */
    public function getLastNewsByCategoryAction(
        Request $request, NewsCategory $category, int $countInPage, News $news
    )
    {
        $parameters = [
            'elements' => $this->paginator->paginate(
                $this->newsRepository->getElementsByCategoryAndNotThisNewsWithLimit($category, $news),
                $request->query->getInt('page', 1), $countInPage
            )
        ];

        return $this->render('news/_last_news.html.twig', $parameters);
    }

    /**
     * @param Request $request
     * @param News $news
     * @param int $countInPage
     * @return Response
     */
    public function getTagsSliderAction(
        Request $request, News $news, int $countInPage
    )
    {
        $parameters = [
            'elements' => $this->paginator->paginate(
                $this->newsRepository->getElementsForTagsSliderWithLimit($news),
                $request->query->getInt('page', 1), $countInPage
            )
        ];

        return $this->render('news/_tags_slider.html.twig', $parameters);
    }

    /**
     * @param Request $request
     * @param NewsAuthorInterface $author
     * @param int $page
     * @param int $countInPage
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    private function helperForGetElementsByAuthorWithStandardPaginationAction(
        Request $request, NewsAuthorInterface $author, int $page, int $countInPage
    )
    {
        $elements = $this->paginator->paginate(
            $this->newsRepository->getQueryForElementsByAuthor($author),
            $request->query->getInt('page', $page), $countInPage
        );
        $elements->setTemplate('news_author/_pagination_with_standard_pagination.html.twig');
        $elements->setUsedRoute('frontend_news_by_author_list');

        $elements->setParam('countInPage', $countInPage);
        $elements->setParam('author', $author->translate($author->getDefaultLocale())->getSlug());

        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $this->translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    /**
     * @param Request $request
     * @param NewsAuthorInterface $author
     * @param int $page
     * @param int $countInPage
     * @return Response
     */
    public function getNewsElementsByAuthorWithStandardPaginationAction(
        Request $request, NewsAuthorInterface $author, int $page, int $countInPage
    )
    {
        $elements = self::helperForGetElementsByAuthorWithStandardPaginationAction(
            $request, $author, $page, $countInPage
        );

        $parameters = [
            'elements' => $elements,
            'isKnpPaginationRender' => true
        ];

        return $this->render('news_author/_news_paginated_elements_with_standard_pagination.html.twig', $parameters);
    }
   /**
    * @param int $news
    * @return Response
    */
   public function getNewsGalleryImagesAction(int $news)
   {
       $element = $this->newsRepository->getNewsGalleryImagesByNewsId($news);

       if (!$element) {
           throw $this->createNotFoundException(
               $this->translator->trans('ui.notFound', [], 'DashboardBundle')
           );
       }

       $parameters = [
           'element' => $element
       ];

       return $this->render('news/_galleryImages.html.twig', $parameters);
   }
}