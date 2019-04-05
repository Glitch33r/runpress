<?php

namespace ComponentBundle\Entity\Message;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface MessageInterface
{
    /**
     * @return null|string
     */
    public function getMessage(): ?string;

    /**
     * @param string $message
     */
    public function setMessage(string $message): void;
}
