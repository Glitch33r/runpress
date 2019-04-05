<?php

namespace UserBundle\Entity;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ToggleableInterface
{
    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @param bool $enabled
     */
    public function setEnabled(?bool $enabled): void;

    /**
     *
     */
    public function enable(): void;

    /**
     *
     */
    public function disable(): void;
}
