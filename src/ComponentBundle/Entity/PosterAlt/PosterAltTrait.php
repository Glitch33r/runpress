<?php

namespace ComponentBundle\Entity\PosterAlt;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait PosterAltTrait
{
    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="poster_alt", type="string", length=255, nullable=true)
     */
    private $posterAlt;

    /**
     * @return string
     */
    public function getPosterAlt(): ?string
    {
        return $this->posterAlt;
    }

    /**
     * @param string $posterAlt
     */
    public function setPosterAlt(?string $posterAlt): void
    {
        $this->posterAlt = $posterAlt;
    }
}