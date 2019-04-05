<?php

namespace ComponentBundle\Entity\ShortDescription;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ShortDescriptionInterface
{
    /**
     * @return string
     */
    public function getShortDescription(): ?string;

    /**
     * @param string $shortDescription
     */
    public function setShortDescription(?string $shortDescription): void;
}
