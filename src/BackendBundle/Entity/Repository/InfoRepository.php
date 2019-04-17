<?php

namespace BackendBundle\Entity\Repository;

use BackendBundle\Entity\Info;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use DashboardBundle\Entity\Repository\DashboardRepository;

/**
 * @author Design studio origami <https://origami.ua>
 */
class InfoRepository extends DashboardRepository
{
    /**
     * Общая часть запроса для всех других запросов
     * @return QueryBuilder
     */
    private function createQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('q')
            ->addSelect('q, t, seo, seo_t')
            ->leftJoin('q.translations', 't')
            ->leftJoin('q.seo', 'seo')
            ->leftJoin('seo.translations', 'seo_t');
    }

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

    public function getLimitElements(int $count = null)
    {
        $query = self::createQuery();
        $query
            ->addOrderBy('q.position', 'DESC')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->andWhere('q.publishAt <=:publishAt')
            ->addOrderBy('q.publishAt', 'DESC')
            ->addOrderBy('q.position', 'DESC')
            ->setParameters([
                'publishAt' => new \DateTime('now'),
                'showOnWebsite' => Info::YES,
            ]);

        if (!is_null($count)) {
            $query->setMaxResults($count);
        }

        return $query->getQuery()->getResult();
    }

    public function getQueryForLimitElements(int $count = null): Query
    {
        $query = self::createQuery();
        $query
            ->addOrderBy('q.publishAt', 'DESC')
            ->addOrderBy('q.position', 'DESC')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->andWhere('q.publishAt <=:publishAt')
            ->setParameters([
                'publishAt' => new \DateTime('now'),
                'showOnWebsite' => Info::YES,
            ]);

        if (!is_null($count)) {
            $query->setMaxResults($count);
        }

        return $query->getQuery();
    }

    private function getQueryForElementBySlug(string $slug): QueryBuilder
    {
        $query = self::createQuery();
        $query
            ->where('t.slug =:slug')
            ->andWhere('q.publishAt <=:publishAt')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->setMaxResults(1);

        $query
            ->setParameters([
                'publishAt' => new \DateTime('now'),
                'slug' => $slug,
                'showOnWebsite' => Info::YES,
            ]);

        return $query;
    }

    public function getElementBySlug(string $slug): ?Info
    {
        return self::getQueryForElementBySlug($slug)->getQuery()->getOneOrNullResult();
    }
}