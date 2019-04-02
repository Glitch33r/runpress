<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ContactStatusRepositoryInterface
{
    public function getContactStatusesForContactForm(): QueryBuilder;
}
