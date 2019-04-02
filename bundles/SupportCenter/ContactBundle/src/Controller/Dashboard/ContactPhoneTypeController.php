<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Controller\Dashboard;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactPhoneType;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class ContactPhoneTypeController extends AbstractController
{
    /**
     * @param TranslatorInterface $translator
     * @return string
     */
    public function getHeadTitle(TranslatorInterface $translator): string
    {
        return $translator->trans('sidebar.contacts.contacts', [], 'DashboardBundle') . ' > '
            . $translator->trans('sidebar.contacts.contact_phones', [], 'DashboardBundle');
    }

    /**
     * @return array
     */
    public function getGrantedRoles(): array
    {
        return [
            'index' => 'ROLE_CONTACT_PHONE_LIST', 'new' => 'ROLE_CONTACT_PHONE_CREATE',
            'edit' => 'ROLE_CONTACT_PHONE_EDIT', 'delete' => 'ROLE_CONTACT_PHONE_DELETE',
        ];
    }

    /**
     * @return array
     */
    public function getRouteElements(): array
    {
        return [
            'index' => 'dashboard_contact_phone_type_index', 'new' => 'dashboard_contact_phone_type_new',
            'edit' => 'dashboard_contact_phone_type_edit', 'delete' => 'dashboard_contact_phone_type_delete',
        ];
    }

    /**
     * @param EntityManagerInterface $em
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getRepository(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(ContactPhoneType::class);

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
            'order_column' => 'position',
            'order_by' => "asc"
        ];
    }

    /**
     * @param TranslatorInterface $translator
     * @return array
     */
    public function getListElementsForIndexDashboard(TranslatorInterface $translator): array
    {
        return [
            'translations-title' => $translator->trans('ui.title', [], 'DashboardBundle'),
            'position' => $translator->trans('form.position', [], 'DashboardBundle'),
            'showOnWebsite' => $translator->trans('form.show_on_website', [], 'DashboardBundle'),
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
            'translations-title' => $item->translate()->getTitle(),
            'position' => $item->getPosition(),
            'showOnWebsite' => $item->getShowOnWebsite()
        ];
    }
}