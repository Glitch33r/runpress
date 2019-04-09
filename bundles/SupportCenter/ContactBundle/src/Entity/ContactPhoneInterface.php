<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use ComponentBundle\Entity\Id\IdInterface;
use ComponentBundle\Entity\Position\PositionInterface;
use ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteInterface;
use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;

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
