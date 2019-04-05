<?php

namespace UserBundle\Entity;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface UserAwareInterface
{
    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface;

    /**
     * @param UserInterface|null $user
     */
    public function setUser(UserInterface $user);
}
