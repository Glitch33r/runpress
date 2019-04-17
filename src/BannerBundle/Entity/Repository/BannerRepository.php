<?php

namespace BannerBundle\Entity\Repository;

use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;
use Doctrine\ORM\QueryBuilder;
use DashboardBundle\Entity\Repository\DashboardRepository;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class BannerRepository extends DashboardRepository
{
    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getElementByIdForDashboardEditOrDeleteFormAction(int $id)
    {
        $query = self::createQuery();
        $query
            ->where('q.id =:id')
            ->setParameter('id', $id);

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * Общая часть запроса для всех других запросов
     * @return QueryBuilder
     */
    private function createQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('q')
            ->addSelect('q');
    }

    public function getRandomBannerByType($type, $limit = 1)
    {
        $query = self::createQuery();
        $query
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->andWhere('q.type =:type')
            ->setParameter('showOnWebsite', YesOrNoInterface::YES)
            ->setParameter('type', $type)
            ->setMaxResults($limit);
    }

    public function getOneBannerByTypeForPage($type, $page)
    {
        return self::createQuery()
            ->addOrderBy('q.updatedAt')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->andWhere('q.type =:type')
            ->andWhere('q.page =:page')
            ->setParameter('showOnWebsite', YesOrNoInterface::YES)
            ->setParameter('type', $type)
            ->setParameter('page', $page)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
