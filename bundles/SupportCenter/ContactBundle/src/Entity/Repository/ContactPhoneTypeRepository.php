<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository;

use Doctrine\Common\Collections\Collection;
use IhorDrevetskyi\DashboardBundle\Entity\Repository\DashboardRepository;
use IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactPhoneTypeInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactPhoneTypeRepository extends DashboardRepository
{
    public function getContactPhoneType(): Collection
    {
        $query = $this->createQueryBuilder('q')
            ->select('q, t, contactPhones')
            ->leftJoin('q.translations', 't')
            ->leftJoin('q.contactPhones', 'contactPhones', 'WITH', 'contactPhones.showOnWebsite = :showOnWebsite')
            ->addOrderBy('q.position', 'ASC')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->setParameter('showOnWebsite', ContactPhoneTypeInterface::YES);

        return $query->getQuery()->getResult();
    }
}