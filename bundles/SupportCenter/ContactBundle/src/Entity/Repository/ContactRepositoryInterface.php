<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ContactRepositoryInterface
{
    public function countNewContactRequests(): int;
}
