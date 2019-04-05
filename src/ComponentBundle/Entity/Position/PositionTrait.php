<?php

namespace ComponentBundle\Entity\Position;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait PositionTrait
{
    /**
     * @var integer
     *
     * @Gedmo\Versioned
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    protected $position;

    /**
     * @return int|null
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
}
