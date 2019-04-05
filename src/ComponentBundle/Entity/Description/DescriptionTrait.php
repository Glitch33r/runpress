<?php

namespace ComponentBundle\Entity\Description;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait DescriptionTrait
{
    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
