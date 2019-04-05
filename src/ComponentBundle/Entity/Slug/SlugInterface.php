<?php

namespace ComponentBundle\Entity\Slug;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface SlugInterface
{
    /**
     * @return string
     */
    public function getSlug(): ?string;

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void;
}
