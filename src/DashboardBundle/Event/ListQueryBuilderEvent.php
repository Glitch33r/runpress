<?php

namespace DashboardBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Doctrine\ORM\QueryBuilder;
use UserBundle\Entity\User;

class ListQueryBuilderEvent extends Event
{
    private $queryBuilder;

    private $user;

    public function setQueryBuilder($queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}