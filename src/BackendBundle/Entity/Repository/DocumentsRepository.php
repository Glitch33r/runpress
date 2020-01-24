<?php

namespace BackendBundle\Entity\Repository;

use BackendBundle\Entity\Documents;
use BackendBundle\Entity\Currency;
use BackendBundle\Entity\CurrencyAuction;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use DashboardBundle\Entity\Repository\DashboardRepository;

class DocumentsRepository extends DashboardRepository
{
    public function getElementByIdForDashboardEditOrDeleteFormAction(int $id)
    {
        $query = self::getQuery();
        $query->select('q, t')
            ->where('q.id =:id')
            ->setParameter('id', $id);

        return $query->getQuery()->getOneOrNullResult();
    }

    private function getQuery()
    {
        $query = $this->createQueryBuilder('q')
            ->leftJoin('q.translations', 't');

        return $query;
    }

    public function getElementBySystemName($slug)
    {
        $query = self::getQuery()
            ->select('q, t')
            ->where('q.systemName = :systemName')
            ->setParameters([
                'systemName' => $slug,
            ]);

        return $query->getQuery()->getOneOrNullResult();
    }


    public function getFrontendElements()
    {
        $query = self::getQuery()
            ->select('q, t')
            ->where('q.showOnWebsite=:showOnWebsite')
            ->setParameter('showOnWebsite', Documents::YES);

        return $query->getQuery()->getResult();
    }

    public function getByIdsForSearch($ids, $isOnlyQuery)
    {
        $query = self::getQuery();
        $query
            ->andWhere('q.id IN (:ids)')
            ->setParameters([
                'ids' => $ids,
            ]);

        $results = $query->getQuery();

        if (!$isOnlyQuery) {
            $results = $query->getQuery()->getResult();
        }

        return $results;
    }
}
