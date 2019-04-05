<?php

namespace ComponentBundle\Entity\Description;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface DescriptionInterface
{
    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void;
}
