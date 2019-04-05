<?php

namespace ComponentBundle\Entity\IsEnable;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface IsEnableInterface
{
    /**
     * @return bool
     */
    public function getIsEnable(): bool;

    /**
     * @param bool $isEnable
     */
    public function setIsEnable(bool $isEnable): void;
}