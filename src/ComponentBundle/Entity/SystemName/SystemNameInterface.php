<?php

namespace ComponentBundle\Entity\SystemName;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface SystemNameInterface
{
    /**
     * @return null|string
     */
    public function getSystemName(): ?string;

    /**
     * @param string $systemName
     */
    public function setSystemName(string $systemName): void;
}
