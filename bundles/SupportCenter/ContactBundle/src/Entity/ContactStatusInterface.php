<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use ComponentBundle\Entity\__Call\__CallInterface;;
use ComponentBundle\Entity\Id\IdInterface;
use ComponentBundle\Entity\Position\PositionInterface;
use ComponentBundle\Entity\SystemName\SystemNameInterface;
use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ContactStatusInterface extends YesOrNoInterface,
    IdInterface, __CallInterface, PositionInterface, SystemNameInterface
{
    /**
     * @return string
     */
    public function __toString(): string;
}
