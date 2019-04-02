<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\Message\MessageInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Id\IdInterface;
use IhorDrevetskyi\UserBundle\Entity\CreatedByInterface;
use IhorDrevetskyi\UserBundle\Entity\UpdatedByInterface;
use IhorDrevetskyi\UserBundle\Entity\PersonalInformation\PersonalInformationExtendedInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ContactInterface extends
    CreatedByInterface,
    UpdatedByInterface,
    PersonalInformationExtendedInterface,
    IdInterface,
    MessageInterface
{
    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return null|string
     */
    public function getSubject(): ?string;

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void;

    /**
     * @return ContactStatusInterface|null
     */
    public function getStatus(): ?ContactStatusInterface;

    /**
     * @param ContactStatusInterface $status
     */
    public function setStatus(ContactStatusInterface $status): void;
}
