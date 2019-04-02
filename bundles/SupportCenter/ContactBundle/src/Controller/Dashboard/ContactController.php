<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Controller\Dashboard;

use Doctrine\ORM\EntityManagerInterface;
use IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class ContactController extends AbstractController
{
    /**
     * @param TranslatorInterface $translator
     * @return string
     */
    public function getHeadTitle(TranslatorInterface $translator): string
    {
        return $translator->trans('sidebar.contacts.contacts', [], 'DashboardBundle');
    }

    /**
     * @return array
     */
    public function getGrantedRoles(): array
    {
        return [
            'index' => 'ROLE_CONTACT_LIST', 'new' => null,
            'edit' => 'ROLE_CONTACT_EDIT', 'delete' => 'ROLE_CONTACT_DELETE',
        ];
    }

    /**
     * @return array
     */
    public function getRouteElements(): array
    {
        return [
            'index' => 'dashboard_contact_index', 'new' => null,
            'edit' => 'dashboard_contact_edit', 'delete' => 'dashboard_contact_delete',
        ];
    }

    /**
     * @param EntityManagerInterface $em
     * @return \Doctrine\Common\Persistence\ObjectRepository|\IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository\ContactRepository
     */
    public function getRepository(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Contact::class);

        return $repository;
    }

    /**
     * @return array
     */
    public function getConfigForIndexDashboard(): array
    {
        return [
            'pageLength' => 25,
            'lengthMenu' => '10, 20, 25, 50, 100, 150',
            'order_column' => 'id',
            'order_by' => "desc"
        ];
    }

    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderNewContactWidget(EntityManagerInterface $em)
    {
        return $this->render('@SupportCenterContact/dashboard/contact/widget/_new_contact_widget.html.twig', [
            'value' => $this->getRepository($em)->countNewContactRequests()
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderTableForHomepage()
    {
        return $this->render('@SupportCenterContact/dashboard/contact/homepage/table/_table.html.twig');
    }

    /**
     * @param TranslatorInterface $translator
     * @return array
     */
    public function getListElementsForIndexDashboard(TranslatorInterface $translator): array
    {
        return [
            'name' => $translator->trans('ui.first_name', [], 'DashboardBundle'),
            'phone' => $translator->trans('form.phone_number', [], 'DashboardBundle'),
            'email' => $translator->trans('ui.email', [], 'DashboardBundle'),
            'subject' => $translator->trans('ui.subject', [], 'DashboardBundle'),
            'status-title' => [
                'locked' => true,
                'title' => $translator->trans('form.status', [], 'DashboardBundle'),
            ],
            'message' => $translator->trans('ui.message.message', [], 'DashboardBundle')
        ];
    }

    /**
     * @param $item
     * @param Environment $twig
     * @return array
     */
    public function createDataForList($item, Environment $twig): array
    {
        return [
            'name' => $item->getName(),
            'phone' => $item->getPhoneNumber(),
            'email' => $item->getEmail(),
            'subject' => $item->getSubject(),
            'status-title' => $item->getStatus(),
            'message' => $item->getMessage()
        ];
    }
}
