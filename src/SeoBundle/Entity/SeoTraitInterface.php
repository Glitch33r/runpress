<?php

namespace SeoBundle\Entity;

/**
 * Interface SeoTraitInterface
 * @package SeoBundle\Entity
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface SeoTraitInterface
{
    /**
     * @return SeoInterface|null
     */
    public function getSeo(): ?SeoInterface;

    /**
     * @param SeoInterface $seo
     */
    public function setSeo(SeoInterface $seo): void;
}
