<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Controller\Dashboard;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactManager;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactManagerController extends AbstractController
{
    /**
     * @param TranslatorInterface $translator
     * @return string
     */
    public function getHeadTitle(TranslatorInterface $translator): string
    {
        return $translator->trans('sidebar.contacts.contacts', [], 'DashboardBundle') . ' > '
            . $translator->trans('sidebar.contacts.contact_settings.contact_settings', [], 'DashboardBundle') . ' > ' .
            $translator->trans('sidebar.contacts.contact_settings.contact_managers', [], 'DashboardBundle');
    }

    /**
     * @return array
     */
    public function getGrantedRoles(): array
    {
        return [
            'index' => 'ROLE_CONTACT_MANAGER_LIST', 'new' => 'ROLE_CONTACT_MANAGER_CREATE',
            'edit' => 'ROLE_CONTACT_MANAGER_EDIT', 'delete' => 'ROLE_CONTACT_MANAGER_DELETE',
        ];
    }

    /**
     * @return array
     */
    public function getRouteElements(): array
    {
        return [
            'index' => 'dashboard_contact_manager_index', 'new' => 'dashboard_contact_manager_new',
            'edit' => 'dashboard_contact_manager_edit', 'delete' => 'dashboard_contact_manager_delete',
        ];
    }

    /**
     * @param EntityManagerInterface $em
     * @return \Doctrine\Common\Persistence\ObjectRepository|mixed
     */
    public function getRepository(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(ContactManager::class);

        return $repository;
    }

    /**
     * @param TranslatorInterface $translator
     * @return array
     */
    public function getListElementsForIndexDashboard(TranslatorInterface $translator): array
    {
        return [
            'name' => $translator->trans('ui.first_name', [], 'DashboardBundle'),
            'email' => $translator->trans('ui.email', [], 'DashboardBundle'),
            'isSendForEmail' => $translator->trans('form.is_send_for_email', [], 'DashboardBundle'),
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
            'email' => $item->getEmail(),
            'isSendForEmail' => $item->getIsSendForEmail(),
        ];
    }
}