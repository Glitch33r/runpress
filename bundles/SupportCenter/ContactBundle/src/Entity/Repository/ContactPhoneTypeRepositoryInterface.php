<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository;

use Doctrine\Common\Collections\Collection;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ContactPhoneTypeRepositoryInterface
{
    public function getContactPhoneType(): Collection;
}