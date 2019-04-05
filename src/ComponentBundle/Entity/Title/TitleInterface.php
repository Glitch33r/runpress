<?php

namespace ComponentBundle\Entity\Title;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface TitleInterface
{
    /**
     * @return null|string
     */
    public function getTitle(): ?string;

    /**
     * @param string $title
     */
    public function setTitle(string $title): void;
}
