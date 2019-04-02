<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository;

use IhorDrevetskyi\DashboardBundle\Entity\Repository\DashboardRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactStatusRepository extends DashboardRepository implements ContactStatusRepositoryInterface
{
    public function getContactStatusesForContactForm(): QueryBuilder
    {
        $query = $this->createQueryBuilder('q')
            ->select('q, t')
            ->leftJoin('q.translations', 't')
            ->addOrderBy('q.position', 'asc');

        return $query;
    }
}