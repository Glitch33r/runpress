<?php

namespace UserBundle\Entity\PersonalInformation;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface PersonalInformationExtendedInterface extends PersonalInformationInterface
{
    /**
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void;
}
