<?php

namespace ComponentBundle\Entity\Poster;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait PosterTrait
{
    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="poster", type="text", nullable=true)
     */
    private $poster;

    /**
     * @return string
     */
    public function getPoster(): ?string
    {
        return $this->poster;
    }

    /**
     * @param string $poster
     */
    public function setPoster(?string $poster): void
    {
        $this->poster = $poster;
    }
}