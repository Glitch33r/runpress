<?php

namespace ComponentBundle\Entity\PosterAlt;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface PosterAltInterface
{
    /**
     * @return string
     */
    public function getPosterAlt(): ?string;

    /**
     * @param string $posterAlt
     */
    public function setPosterAlt(?string $posterAlt): void;
}