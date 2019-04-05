<?php

namespace ComponentBundle\Entity\Poster;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface PosterInterface
{
    /**
     * @return string
     */
    public function getPoster(): ?string;

    /**
     * @param string $poster
     */
    public function setPoster(?string $poster): void;
}