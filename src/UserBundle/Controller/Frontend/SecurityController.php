<?php

namespace UserBundle\Controller\Frontend;

use SeoBundle\Utils\SeoManager;
use Symfony\Component\HttpFoundation\Response;
use ComponentBundle\Utils\BreadcrumbsGenerator;
use UserBundle\Form\Type\Frontend\UserLoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class SecurityController extends AbstractController
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authChecker;

    /**
     * @var BreadcrumbsGenerator
     */
    protected $breadcrumbsGenerator;

    /**
     * @var AuthenticationUtils
     */
    protected $helper;

    /**
     * @var SeoManager
     */
    protected $seoManager;

    /**
     * SecurityController constructor.
     * @param AuthorizationCheckerInterface $authChecker
     * @param BreadcrumbsGenerator $breadcrumbsGenerator
     * @param AuthenticationUtils $helper
     * @param SeoManager $seoManager
     */
    public function __construct(
        AuthorizationCheckerInterface $authChecker, BreadcrumbsGenerator $breadcrumbsGenerator,
        AuthenticationUtils $helper, SeoManager $seoManager
    )
    {
        $this->authChecker = $authChecker;
        $this->breadcrumbsGenerator = $breadcrumbsGenerator;
        $this->helper = $helper;
        $this->seoManager = $seoManager;
    }

    /**
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loginAction(): Response
    {
        if ($this->authChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('frontend_homepage');
        }

        // last authentication error (if any)
        $error = $this->helper->getLastAuthenticationError();
        // last username entered by the user (if any)
        $lastUsername = $this->helper->getLastUsername();
        $form = $this->createForm(UserLoginType::class, null);
        $seo = $this->seoManager->getSeoForPage('login');

        $breadcrumbsArr = $this->breadcrumbsGenerator->getBreadcrumbForHomePage();

        $breadcrumbsArr['security_login'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        return $this->render('@User/user/security/login.html.twig', [
            'last_username' => $lastUsername,
            'last_error' => $error,
            'form' => $form->createView(),
            'seo' => $seo,
            'breadcrumbs' => $this->breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr),
        ]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically.
     */
    public function logout(): void
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
