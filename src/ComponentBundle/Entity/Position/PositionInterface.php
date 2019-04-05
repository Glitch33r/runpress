<?php

namespace ComponentBundle\Entity\Position;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface PositionInterface
{
    /**
     * @return int|null
     */
    public function getPosition(): ?int;

    /**
     * @param int $position
     */
    public function setPosition(int $position): void;
}
