<?php

namespace UserBundle\Entity\Repository;

use DashboardBundle\Entity\Repository\DashboardRepository;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class UserRepository extends DashboardRepository implements UserRepositoryInterface
{
    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->createQueryBuilder('q')
            ->select('q')
            ->addOrderBy('q.id', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

    public function getElementsIndexByEmail(): array
    {
        return $this->createQueryBuilder('q')
            ->select('q')
            ->indexBy('q', 'q.email')
            ->getQuery()
            ->getResult();
    }
}