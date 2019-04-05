<?php

namespace ComponentBundle\Entity\Id;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait IdTrait
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @Gedmo\Versioned
     */
    private $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
