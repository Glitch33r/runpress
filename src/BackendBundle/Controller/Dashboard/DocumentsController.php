<?php

namespace BackendBundle\Controller\Dashboard;

use BackendBundle\Entity\Currency;
use BackendBundle\Entity\CurrencyAuction;
use BackendBundle\Entity\Documents;
use BackendBundle\Form\Type\Dashboard\CurrencyAuctionType;
use BackendBundle\Form\Type\Dashboard\CurrencyType;
use BackendBundle\Form\Type\Dashboard\DocumentsType;
use DashboardBundle\Controller\CRUDController;
use SeoBundle\Entity\Seo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class DocumentsController extends CRUDController
{
    public function getHeadTitle(): string
    {
        return 'Документы';
    }

    public function getGrantedRoles(): array
    {
        return [
            'index' => 'ROLE_DIRECTOR', 'new' => 'ROLE_DIRECTOR',
            'edit' => 'ROLE_DIRECTOR', 'delete' => 'ROLE_DIRECTOR',
        ];
    }

    public function getRouteElements(): array
    {
        return [
            'index' => 'dashboard_documents_index', 'new' => 'dashboard_documents_new',
            'edit' => 'dashboard_documents_edit', 'delete' => 'dashboard_documents_delete',
        ];
    }

    public function getCaptionSubjectIcon(): string
    {
        return 'icon-folder';
    }

    public function getFormType(): string
    {
        return DocumentsType::class;
    }

    public function getFormElement()
    {
        $data = new Documents();

        return $data;
    }

    public function getRepository(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Documents::class);

        return $repository;
    }

    public function getListElementsForIndexDashboard(TranslatorInterface $translator): array
    {
        return [
            'translations-title' => $translator->trans('ui.title', [], 'DashboardBundle'),
//            'document' => 'Файл',
            'position' => $translator->trans('ui.position', [], 'DashboardBundle'),
            'showOnWebsite' => $translator->trans('ui.show_on_website', [], 'DashboardBundle'),

        ];
    }

    public function getConfigForIndexDashboard(): array
    {
        return [
            'pageLength' => 25,
            'lengthMenu' => '10, 20, 25, 50, 100, 150',
            'order_column' => 'id',
            'order_by' => "desc"
        ];
    }

    public function getElementsForIndexDashboard(Request $request, EntityManagerInterface $em, TranslatorInterface $translator, Environment $twig)
    {
        return [
            'translations-title' => $translator->trans('ui.title', [], 'DashboardBundle'),
            'position' => $translator->trans('ui.position', [], 'DashboardBundle'),
            'showOnWebsite' => $translator->trans('ui.show_on_website', [], 'DashboardBundle'),
            'publishAt' => $translator->trans('ui.date', [], 'DashboardBundle'),
        ];

        $repository = $this->getRepository($em);

        $iTotalRecords = $repository->countAllElementsForIndexDashboard();
        $elements = $repository->allElementsForIndexDashboard($request);

        $helper = $this->dashboardManager->helperForIndexDashboard($iTotalRecords, $elements);
        $pagination = $helper['pagination'];
        $records = $helper['records'];

        foreach ($pagination as $element) {
            $records["data"][] = [
                $element->getId(),
                $element->translate()->getTitle(),
//                $twig->render('@Backend/dashboard/documents/_file_html.twig', ['element' => $element->getDocument()]),
                $element->getPosition(),
                $twig->render('@Dashboard/default/list/_yes_no.html.twig', ['element' => $element->getShowOnWebsite()]),
                $twig->render('@Dashboard/default/list/_actions_edit_delete.html.twig', [
                    'action_edit_url' => $this->generateUrl($this->getRouteElements()['edit'], ['id' => $element->getId()]),
                    'action_delete_url' => $this->generateUrl($this->getRouteElements()['delete'], ['id' => $element->getId()]),
                    'action_edit_role' => $this->getGrantedRoles()['edit'],
                    'action_delete_role' => $this->getGrantedRoles()['delete'],
                ]),
            ];
        }

        return $records;
    }

    public function createDataForList($item, Environment $twig): array
    {
        return [
            'translations-title' => $item->translate()->getTitle(),
            'position' => $item->getPosition(),
            'showOnWebsite' => $twig->render('@Dashboard/default/crud/list/element/_yes_no.html.twig', [
                'element' => $item->getShowOnWebsite()
            ]),
        ];
    }

    public function getPortletBodyTemplateForForm(): string
    {
        return '@Backend/dashboard/documents/form/_portlet_body.html.twig';
    }
}
