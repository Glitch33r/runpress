<?php

namespace ComponentBundle\Entity\Img;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ImgInterface
{
    /**
     * @return string
     */
    public function getImg(): ?string;

    /**
     * @param string $img
     */
    public function setImg(?string $img): void;
}