<?php

namespace SeoBundle\Entity;

use ComponentBundle\Entity\Id\IdInterface;

/**
 * Interface SeoInterface
 * @package SeoBundle\Entity
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface SeoInterface extends IdInterface
{
    /**
     * @return mixed
     */
    public function getSeoForPage();
}
