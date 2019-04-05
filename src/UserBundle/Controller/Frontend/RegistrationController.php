<?php

namespace UserBundle\Controller\Frontend;

use UserBundle\UserEvents;
use SeoBundle\Utils\SeoManager;
use ComponentBundle\Event\FormEvent;
use UserBundle\Entity\UserInterface;
use Symfony\Component\Form\FormError;
use UserBundle\Utils\UserManagerInterface;
use UserBundle\Event\GetResponseUserEvent;
use ComponentBundle\Storage\SessionStorage;
use UserBundle\Form\Type\Frontend\UserType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Event\FilterUserResponseEvent;
use ComponentBundle\Utils\BreadcrumbsGenerator;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class RegistrationController extends AbstractController
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var BreadcrumbsGenerator
     */
    protected $breadcrumbsGenerator;

    /**
     * @var SeoManager
     */
    protected $seoManager;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authChecker;

    /**
     * RegistrationController constructor.
     * @param UserManagerInterface $userManager
     * @param BreadcrumbsGenerator $breadcrumbsGenerator
     * @param EventDispatcherInterface $eventDispatcher
     * @param SeoManager $seoManager
     * @param TranslatorInterface $translator
     * @param AuthorizationCheckerInterface $authChecker
     */
    public function __construct(
        UserManagerInterface $userManager, BreadcrumbsGenerator $breadcrumbsGenerator,
        EventDispatcherInterface $eventDispatcher, SeoManager $seoManager,
        TranslatorInterface $translator, AuthorizationCheckerInterface $authChecker
    )
    {
        $this->authChecker = $authChecker;
        $this->translator = $translator;
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager = $userManager;
        $this->seoManager = $seoManager;
        $this->breadcrumbsGenerator = $breadcrumbsGenerator;
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function registrationAction(Request $request)
    {
        if ($this->authChecker->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('frontend_homepage'));
        }

        $user = $this->userManager->createUser();
        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(UserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $userInDb = $this->userManager->findUserByEmail($user->getEmail());
        }

        if ($form->isSubmitted() && $form->isValid() and empty($userInDb)) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(UserEvents::REGISTRATION_SUCCESS, $event);
            $this->userManager->updateUser($user);

            $response = $event->getResponse();
            if (null === $response) {
                $url = $this->generateUrl('registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher
                ->dispatch(
                    UserEvents::REGISTRATION_COMPLETED,
                    new FilterUserResponseEvent($user, $request, $response)
                );

            return $response;
        } else {
            if (!empty($userInDb)) {
                $form->get('email')
                    ->addError(
                        new FormError(
                            $this->translator->trans('user.email.unique', [], 'UserValidators')
                        )
                    );
            }

            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(UserEvents::REGISTRATION_FAILURE, $event);

            $response = $event->getResponse();

            if (null !== $response) {
                return $response;
            }
        }

        $seo = $this->seoManager->getSeoForPage('registration');
        $breadcrumbsArr = $this->breadcrumbsGenerator->getBreadcrumbForHomePage();
        $breadcrumbsArr['registration'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $breadcrumbs = $this->breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr);

        return $this->render('user/registration/registration.html.twig', [
            'form' => $form->createView(),
            'seo' => $seo,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @param Request $request
     * @param $token
     * @return RedirectResponse
     * @throws \Exception
     */
    public function confirmAction(Request $request, $token)
    {
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(
                sprintf('The user with confirmation token "%s" does not exist', $token)
            );
        }

        $user->setEmailVerificationToken(null);
        $user->setEnabled(true);
        $user->setVerifiedAt(new \DateTime());

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(UserEvents::REGISTRATION_CONFIRM, $event);

        $this->userManager->updateUser($user);

        $response = $event->getResponse();

        if (null === $response) {
            $url = $this->generateUrl('registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $this->eventDispatcher->dispatch(
            UserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response)
        );

        return $response;
    }

    /**
     * @param SessionStorage $sessionStorage
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function checkEmail(SessionStorage $sessionStorage)
    {
        $email = $sessionStorage->get('user_send_confirmation_email/email');

        if (empty($email)) {
            return new RedirectResponse($this->generateUrl('registration'));
        }

        $sessionStorage->remove('user_send_confirmation_email/email');
        $user = $this->userManager->findUserByEmail($email);

        if (null === $user) {
            return new RedirectResponse($this->get('router')->generate('login'));
        }

        $seo = $this->seoManager->getSeoForPage('check_email');
        $breadcrumbsArr = $this->breadcrumbsGenerator->getBreadcrumbForHomePage();
        $breadcrumbsArr['registration_check_email'][] = [
            'parameters' => [],
            'title' => (!empty($seo) and !empty($seo->breadcrumb)) ? $seo->breadcrumb : ''
        ];

        $breadcrumbs = $this->breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr);

        return $this->render('user/registration/check_email.html.twig', [
            'user' => $user,
            'seo' => $seo,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->redirectToRoute('frontend_homepage');

//        $seo = $em->getRepository(SeoPage::class)->getSeoForPageBySystemName('confirmed');
//        if (empty($seo)) {
//            $seo = new Seo();
//            $locale = $this->getParameter('locale');
//            $seo->translate($locale)->setMetaTitle('confirmed');
//            $seo->translate($locale)->setH1('confirmed');
//            $seo->translate($locale)->setBreadcrumb('confirmed');
//            $seoPage = new SeoPage();
//            $seoPage->setSystemName('confirmed');
//            $seoPage->setSeo($seo);
//            $seo->mergeNewTranslations();
//            $em->persist($seo);
//            $em->persist($seoPage);
//            $em->flush();
//            $seo = $seoPage;
//        }
//        return $this->render('user/registration/confirmed.html.twig', array(
//            'user' => $user,
//            'seo' => $seo,
//        ));
    }
}
