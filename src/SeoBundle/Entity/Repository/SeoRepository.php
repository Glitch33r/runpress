<?php

namespace SeoBundle\Entity\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
abstract class SeoRepository
{
    /**
     * @param QueryBuilder $query
     * @return QueryBuilder
     */
    public static function addSeo(QueryBuilder $query): QueryBuilder
    {
        $query
            ->addSelect('seo, seo_t')
            ->leftJoin('q.seo', 'seo')
            ->leftJoin('seo.translations', 'seo_t');

        return $query;
    }
}
