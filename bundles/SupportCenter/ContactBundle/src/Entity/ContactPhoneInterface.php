<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\Id\IdInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Position\PositionInterface;
use IhorDrevetskyi\ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteInterface;
use IhorDrevetskyi\ComponentBundle\Entity\YesOrNo\YesOrNoInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ContactPhoneInterface extends YesOrNoInterface, IdInterface, PositionInterface, ShowOnWebsiteInterface
{
    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string;

    /**
     * @param string $phone
     */
    public function setPhoneNumber(string $phone): void;

    /**
     * @return ContactPhoneTypeInterface|null
     */
    public function getContactPhoneType(): ?ContactPhoneTypeInterface;

    /**
     * @param ContactPhoneTypeInterface $contactPhoneType
     */
    public function setContactPhoneType(ContactPhoneTypeInterface $contactPhoneType): void;
}
