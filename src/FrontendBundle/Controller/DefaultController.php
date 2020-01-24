<?php

namespace FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use ComponentBundle\Utils\BreadcrumbsGenerator;
use Doctrine\ORM\EntityManagerInterface;
use NewsBundle\Entity\News;
use FrontendBundle\Entity\Contacts;
use BackendBundle\Entity\Documents;
use ComponentBundle\Utils\Mailer;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class DefaultController extends \ComponentBundle\Controller\Frontend\DefaultController
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

    public function initHeaderAction(EntityManagerInterface $em, Request $request)
    {
        return $this->render('default/_header.html.twig', [
            'request' => $request
        ]);
    }

    public function initFooterAction(EntityManagerInterface $em, Request $request)
    {
        $documents = $em->getRepository(Documents::class)->getFrontendElements();
        
        return $this->render('default/_footer.html.twig', [
            'request' => $request,
            'documents' => $documents,
        ]);
    }

    public function contactsAction(
        Request $request,
        BreadcrumbsGenerator $breadcrumbsGenerator,
        Mailer $mailer,
        ParameterBagInterface $params)
    {
        $sent_message = false;
        $breadcrumbsArr = $breadcrumbsGenerator->getBreadcrumbForHomePage();
        $breadcrumbsArr['frontend_contacts_page'][] = [
            'parameters' => [],
            'title' => 'КОНТАКТЫ'
        ];

        $form = $this->createFormBuilder(new Contacts(), ['action' => $this->generateUrl('frontend_contacts_page')])
            ->add('name', TextType::class, ['required' => false])
            ->add('email', EmailType::class, ['required' => true])
            ->add('subject', TextType::class, ['required' => false])
            ->add('text', TextareaType::class, ['required' => true])
            ->add('save', SubmitType::class, ['label' => 'Отправить сообщение'])
            ->getForm();

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $subject = !is_null($form->getData()->subject) ? $form->getData()->subject : 'Форма обратной связи';
                $renderedTemplate = $this->render('mail/feedback.html.twig', [
                    'data' => $form->getData(),
                ]);

                $mailer->sendEmailMessage($subject, $_ENV['FEEDBACK_EMAIL'], $renderedTemplate->getContent());
                $sent_message = true;
            }
        }

        return $this->render('default/contacts.html.twig', [
            'form' => $form->createView(),
            'sent_message' => $sent_message,
            'breadcrumbs' => $breadcrumbsGenerator->generateBreadcrumbs($breadcrumbsArr),
        ]);
    }
}