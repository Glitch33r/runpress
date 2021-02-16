<?php

namespace NewsBundle\Entity\Repository;

use UserBundle\Entity\User;
use Doctrine\ORM\QueryBuilder;
use NewsBundle\Entity\NewsAuthor;
use SeoBundle\Entity\Repository\SeoRepository;
use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;
use DashboardBundle\Entity\Repository\DashboardRepository;

/**
 * @author Design studio origami <https://origami.ua>
 */
class NewsAuthorRepository extends DashboardRepository implements NewsAuthorRepositoryInterface
{
    /**
     * @return QueryBuilder
     */
    private function createQuery(): QueryBuilder
    {
        $query = $this->createQueryBuilder('q')
            ->select('q, t')
            ->leftJoin('q.translations', 't');

        return $query;
    }

    /**
     * @return QueryBuilder
     */
    public function getNewsAuthorForNewsForm(User $user): QueryBuilder
    {
        $query = self::createQuery();
        $query->addOrderBy('q.position', 'ASC');

        if ($user->hasRole('ROLE_JOURNALIST')) {
            $query
                ->andWhere('q.id=:id')
                ->setParameter('id', $user->getAuthor()->getId());
        }

        return $query;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getElementByIdForDashboardEditOrDeleteFormAction(int $id)
    {
        $query = self::createQuery();
        $query = SeoRepository::addSeo($query);
        $query
            ->where('q.id =:id')
            ->setParameter('id', $id);

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        $query = self::createQuery();

        $query
            ->addOrderBy('q.position', 'ASC')
            ->andWhere('q.showOnWebsite =:showOnWebsite')
            ->setParameter('showOnWebsite', YesOrNoInterface::YES);

        return $query->getQuery()->getResult();
    }

    /**
     * @param string $slug
     * @return NewsAuthor|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getElementBySlug(string $slug): ?NewsAuthor
    {
        $query = self::createQuery();

        $query
            ->addSelect('news, news_t')
            ->leftJoin('q.news', 'news', 'WITH', 'news.showOnWebsite = :showOnWebsite')
            ->leftJoin('news.translations', 'news_t')
            ->addOrderBy('news.position', 'ASC')
            ->where('t.slug =:slug')
            ->setParameter('slug', $slug)
            ->setParameter('showOnWebsite', YesOrNoInterface::YES);

        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getForAdminAStat(): array
    {
        $query = self::createQuery();

        $query
            ->addSelect('count(news) as total_news, sum(news.views) as total_views')
            ->leftJoin('q.news', 'news', 'WITH', 'news.publishAt<=:now_date')
            ->groupBy('q ,t')
            ->orderBy('total_news', 'DESC')
            ->setParameters([
                'now_date' => (new \DateTime())->format('Y-m-d H:i:s'),
            ]);

        return $query->getQuery()->getResult();
    }
}