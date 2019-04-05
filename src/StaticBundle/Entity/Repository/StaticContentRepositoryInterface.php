<?php

namespace StaticBundle\Entity\Repository;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface StaticContentRepositoryInterface
{
    /**
     * @param string $page
     * @return array
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function getByPage(string $page): array;
}
