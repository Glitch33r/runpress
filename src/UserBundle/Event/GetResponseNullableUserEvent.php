<?php

namespace UserBundle\Event;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Response user event that allows null user.
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class GetResponseNullableUserEvent extends GetResponseUserEvent
{
    /**
     * GetResponseNullableUserEvent constructor.
     *
     * @param UserInterface|null $user
     * @param Request            $request
     */
    public function __construct(UserInterface $user = null, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }
}
