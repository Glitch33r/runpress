<?php

namespace StaticBundle\Entity\Repository;

use StaticBundle\Entity\StaticPageInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface StaticPageRepositoryInterface
{
    /**
     * @param string $systemName
     * @return StaticPageInterface|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getStaticPageBySystemName(string $systemName): ?StaticPageInterface;
}
