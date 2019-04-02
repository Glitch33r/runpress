<?php

namespace FrontendBundle\Controller;

use BackendBundle\Entity\Video;
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
final class VideoController extends AbstractController
{
    public function indexAction(
        BreadcrumbsGenerator $breadcrumbsGenerator, SeoManager $seoManager
    )
    {
        $breadcrumbsArr = $breadcrumbsGenerator->getBreadcrumbForHomePage();
        $seo = $seoManager->getSeoForPage('video');
        $breadcrumbsArr['frontend_video_list'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $parameters = [
            'seo' => $seo,
            'breadcrumbs' => $breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr),
        ];

        return $this->render('video/index.html.twig', $parameters);
    }

    private function helperForGetElementsInIndexAction(
        Request $request, EntityManagerInterface $em, PaginatorInterface $paginator,
        TranslatorInterface $translator, int $page, int $countInPage
    )
    {
        $videoRepository = $em->getRepository(Video::class);

        $elements = [];

        $videos = $videoRepository->getQueryForLimitElements(null);
        $elements = $paginator->paginate($videos, $request->query->getInt('page', $page), $countInPage);
        $elements->setTemplate('video/_pagination.html.twig');
        $elements->setUsedRoute('frontend_partial_get_video_elements');

        $elements->setParam('countInPage', $countInPage);

        if (count($elements) == 0) {
            throw $this->createNotFoundException(
                $translator->trans('ui.notFound', [], 'DashboardBundle')
            );
        }

        return $elements;
    }

    public function getVideoElementsAction(
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
            return $this->render('video/_paginated_elements.html.twig', $parameters);
        } else {
            $response = new Response(Response::HTTP_OK);

            $response->headers->set('X-Robots-Tag', 'noindex');

            return $this->render('video/paginated_elements.html.twig', $parameters, $response);
        }
    }
}