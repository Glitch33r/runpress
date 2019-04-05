<?php

namespace ComponentBundle\Entity\ShowOnWebsite;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface ShowOnWebsiteInterface
{
    /**
     * @return bool|null
     */
    public function getShowOnWebsite(): ?bool;

    /**
     * @param bool $showOnWebsite
     */
    public function setShowOnWebsite(bool $showOnWebsite): void;
}
