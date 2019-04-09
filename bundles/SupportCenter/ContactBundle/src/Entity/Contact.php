<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use ComponentBundle\Entity\Message\MessageTrait;
use ComponentBundle\Entity\Id\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\CreatedBy\CreatedByTrait;
use UserBundle\Entity\UpdatedBy\UpdatedByTrait;
use UserBundle\Entity\PersonalInformation\PersonalInformationExtendedTrait;

/**
 * Contact
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="contact_table")
 * @ORM\Entity(repositoryClass="IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository\ContactRepository")
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class Contact implements ContactInterface
{
    use ORMBehaviors\Timestampable\Timestampable;
    use CreatedByTrait, UpdatedByTrait;
    use PersonalInformationExtendedTrait;
    use IdTrait;
    use MessageTrait;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     * @ORM\Column(name="subject", type="string", length=255, nullable=false)
     */
    private $subject;

    /**
     * @var \IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactStatus
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_status_id", referencedColumnName="id", onDelete="SET NULL")
     * })
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $status;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getSubject();
    }

    /**
     * @return string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return ContactStatusInterface|null
     */
    public function getStatus(): ?ContactStatusInterface
    {
        return $this->status;
    }

    /**
     * @param ContactStatusInterface $status
     */
    public function setStatus(ContactStatusInterface $status): void
    {
        $this->status = $status;
    }
}
