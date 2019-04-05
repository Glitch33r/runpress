<?php

namespace UserBundle\Security;

use UserBundle\Entity\UserInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface LoginManagerInterface
{
    /**
     * @param string        $firewallName
     * @param UserInterface $user
     * @param Response|null $response
     */
    public function logInUser(string $firewallName, UserInterface $user, Response $response = null);
}
