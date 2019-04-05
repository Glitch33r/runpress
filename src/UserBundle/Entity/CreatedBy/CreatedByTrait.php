<?php

namespace UserBundle\Entity\CreatedBy;

use UserBundle\Entity\UserInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait CreatedByTrait
{
    /**
     * @var \UserBundle\Entity\User
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     */
    private $createdBy;

    public function setCreatedBy(UserInterface $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Get createdBy
     *
     * @return \UserBundle\Entity\UserInterface
     */
    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }
}
