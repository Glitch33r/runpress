<?php

namespace UserBundle\Entity\Repository;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface UserRepositoryInterface
{
    public function getElements(): array;
}