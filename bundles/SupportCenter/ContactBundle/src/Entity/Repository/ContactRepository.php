<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository;

use IhorDrevetskyi\DashboardBundle\Entity\Repository\DashboardRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactRepository extends DashboardRepository implements ContactRepositoryInterface
{
    private function createQuery(): QueryBuilder
    {
        $query = $this->createQueryBuilder('q')
            ->select('q, status, status_t')
            ->leftJoin('q.status', 'status')
            ->leftJoin('status.translations', 'status_t');

        return $query;
    }

    public function countNewContactRequests(): int
    {
        return $this->createQueryBuilder('q')
            ->select('count(q.id)')
            ->where('q.status IS NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
