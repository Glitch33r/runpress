<?php

namespace ComponentBundle\Entity\Video;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface VideoInterface
{
    /**
     * @return string|null
     */
    public function getVideo(): ?string;

    /**
     * @param string|null $video
     */
    public function setVideo(?string $video): void;
}