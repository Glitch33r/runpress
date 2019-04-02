<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\__Call\__CallInterface;;
use IhorDrevetskyi\ComponentBundle\Entity\Id\IdInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Position\PositionInterface;
use IhorDrevetskyi\ComponentBundle\Entity\SystemName\SystemNameInterface;
use IhorDrevetskyi\ComponentBundle\Entity\YesOrNo\YesOrNoInterface;

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
