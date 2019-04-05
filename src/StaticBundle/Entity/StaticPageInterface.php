<?php

namespace StaticBundle\Entity;

use ComponentBundle\Entity\Id\IdInterface;
use ComponentBundle\Entity\SystemName\SystemNameInterface;

/**
 * Interface StaticPageInterface
 * @package StaticBundle\Entity
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface StaticPageInterface extends IdInterface, SystemNameInterface
{
    /**
     * @return string
     */
    public function __toString(): string;
}
