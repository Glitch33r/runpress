<?php

namespace ComponentBundle\Entity\Id;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface IdInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;
}
