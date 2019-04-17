<?php

namespace FrontendBundle\Controller;

use NewsBundle\Controller\Frontend\newsSiteMap;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class SiteMapController extends \ComponentBundle\Controller\Frontend\SiteMapController
{
    use newsSiteMap;

    public function siteMapAction(Request $request, EntityManagerInterface $em, RouterInterface $router)
    {
        $defaultLocale = $this->getParameter('locale');
        $hostname = $request->getSchemeAndHttpHost();
        $urls = [];
        $urls[] = [
            'loc' => $router->generate('frontend_homepage'),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ];

        $urls = array_merge($urls, self::generateSiteMap($em, $defaultLocale, $router));

        return $this->render('@Component/_site_map.xml.twig', [
            'urls' => $urls, 'hostname' => $hostname
        ]);
    }
}
