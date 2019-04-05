<?php

namespace ComponentBundle\Entity\Link;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface LinkInterface
{
    /**
     * @return null|string
     */
    public function getLink(): ?string;

    /**
     * @param null|string $link
     */
    public function setLink(?string $link): void;
}
