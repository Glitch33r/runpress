<?php

namespace ComponentBundle\Entity\Video;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait VideoTrait
{
    /**
     * @var string - video path
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="video", type="text", nullable=true)
     */
    private $video;

    /**
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string|null $video
     */
    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }
}