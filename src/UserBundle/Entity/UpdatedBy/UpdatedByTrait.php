<?php

namespace UserBundle\Entity\UpdatedBy;

use UserBundle\Entity\UserInterface;
use Doctrine\Common\Collections\Collection;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait UpdatedByTrait
{
    /**
     * @return Collection|UserInterface[]
     */
    public function getUpdatedBy(): Collection
    {
        return $this->updatedBy;
    }

    /**
     * @param UserInterface $updatedBy
     */
    public function addUpdatedBy(UserInterface $updatedBy): void
    {
        if (!$this->updatedBy->contains($updatedBy)) {
            $this->updatedBy->add($updatedBy);
        }
    }

    /**
     * @param UserInterface $updatedBy
     */
    public function removeUpdatedBy(UserInterface $updatedBy): void
    {
        if ($this->updatedBy->contains($updatedBy)) {
            $this->updatedBy->removeElement($updatedBy);
        }
    }
}