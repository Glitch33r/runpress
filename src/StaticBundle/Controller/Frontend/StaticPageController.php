<?php

namespace StaticBundle\Controller\Frontend;

use StaticBundle\Entity\StaticPage;
use Doctrine\ORM\EntityManagerInterface;
use ComponentBundle\Utils\BreadcrumbsGenerator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StaticPageController extends AbstractController
{
    public function showAction(BreadcrumbsGenerator $breadcrumbsGenerator, EntityManagerInterface $em,
        TranslatorInterface $translator, string $slug)
    {
        $element = $em->getRepository(StaticPage::class)
            ->getStaticPageBySystemName($slug);

        if (!$element) {
            throw $this
                ->createNotFoundException(
                    $translator->trans('ui.notFound', [], 'DashboardBundle')
                );
        }

        $seo = $element->getSeo()->getSeoForPage();

        $breadcrumbsArr = $breadcrumbsGenerator->getBreadcrumbForHomePage();
        $breadcrumbsArr['frontend_static_page_show'][] = [
            'parameters' => ['slug' => $slug],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : '',
        ];

        $parameters = [
            'seo' => $seo,
            'element' => $element,
            'breadcrumbs' => $breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr)
        ];

        return $this->render('static/show.html.twig', $parameters);
    }
}