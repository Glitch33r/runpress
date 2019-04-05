<?php

namespace UserBundle\Entity\PersonalInformation;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface PersonalInformationInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string;

    /**
     * @param string $phone
     */
    public function setPhoneNumber(string $phone): void;
}
