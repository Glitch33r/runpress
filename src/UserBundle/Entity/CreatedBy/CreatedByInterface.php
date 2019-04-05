<?php

namespace UserBundle\Entity\CreatedBy;

use UserBundle\Entity\UserInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface CreatedByInterface
{
    /**
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy): void;

    /**
     * @return UserInterface|null
     */
    public function getCreatedBy(): ?UserInterface;
}
