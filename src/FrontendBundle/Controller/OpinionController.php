<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Opinion;
use IhorDrevetskyi\SeoBundle\Utils\SeoManager;
use IhorDrevetskyi\ComponentBundle\Utils\BreadcrumbsGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class OpinionController extends AbstractController
{
    public function indexAction(
        BreadcrumbsGenerator $breadcrumbsGenerator, SeoManager $seoManager
    )
    {
        $breadcrumbsArr = $breadcrumbsGenerator->getBreadcrumbForHomePage();
        $seo = $seoManager->getSeoForPage('opinion');
        $breadcrumbsArr['frontend_opinion_index'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $parameters = [
            'seo' => $seo,
            'breadcrumbs' => $breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr),
        ];

        return $this->render('opinion/index.html.twig', $parameters);
    }

    private function helperForGetElementsInIndexAction(
        Request $request, EntityManagerInterface $em, PaginatorInterface $paginator,
        TranslatorInterface $translator, int $page, int $countInPage
    )
    {
        $opinionRepository = $em->getRepository(Opinion::class);

        $elements = [];

        $opinions = $opinionRepository->getQueryForLimitElements(null);
        $elements = $paginator->paginate($opinions, $request->query->getInt('page', $page), $countInPage);
        $elements->setTemplate('opinion/_pagination.html.twig');
        $elements->setUsedRoute('frontend_partial_get_opinion_elements');

        $elements->setParam('countInPage', $countInPage);

        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    public function getOpinionElementsAction(
        Request $request, EntityManagerInterface $em, PaginatorInterface $paginator,
        TranslatorInterface $translator, int $page, int $countInPage, bool $fromTwig = false
    )
    {
        $elements = self::helperForGetElementsInIndexAction(
            $request, $em, $paginator, $translator, $page, $countInPage
        );

        $parameters = [
            'elements' => $elements,
            'isKnpPaginationRender' => !($page == $elements->getPageCount())
        ];

        if ($fromTwig or $request->isXmlHttpRequest()) {
            return $this->render('opinion/_paginated_elements.html.twig', $parameters);
        } else {
            $response = new Response(Response::HTTP_OK);

            $response->headers->set('X-Robots-Tag', 'noindex');

            return $this->render('opinion/paginated_elements.html.twig', $parameters, $response);
        }
    }

    public function showAction(
        BreadcrumbsGenerator $breadcrumbsGenerator, EntityManagerInterface $em,
        TranslatorInterface $translator, SeoManager $seoManager, string $slug
    ){
        $element = $em->getRepository(Opinion::class)->getElementBySlug($slug);

        if (!$element) {
            throw $this
                ->createNotFoundException(
                    $translator->trans('ui.notFound', [], 'DashboardBundle')
                );
        }

        $defaultLocale = $element->getDefaultLocale();
        $elementSlug = $element->translate($defaultLocale)->getSlug();

        $breadcrumbsArr = $breadcrumbsGenerator->getBreadcrumbForHomePage();
        $seo = $seoManager->getSeoForPage('opinion');
        $breadcrumbsArr['frontend_opinion_index'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $seo = $element->getSeo()->getSeoForPage();

        $breadcrumbsArr['frontend_opinion_show'][] = [
            'parameters' => [
                'slug' => $elementSlug
            ],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $parameters = [
            'seo' => $seo,
            'element' => $element,
            'breadcrumbs' => $breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr)
        ];

        return $this->render('opinion/show.html.twig', $parameters);
    }
}