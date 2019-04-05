<?php

namespace SeoBundle\Entity\Repository;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface SeoPageRepositoryInterface
{
    /**
     * @param string $page
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getSeoForPageBySystemName(string $page);
}
