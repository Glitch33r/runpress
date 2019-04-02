<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\Id\IdTrait;
use IhorDrevetskyi\ComponentBundle\Entity\Position\PositionTrait;
use IhorDrevetskyi\ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteTrait;
use IhorDrevetskyi\ComponentBundle\Entity\YesOrNo\YesOrNoTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContactPhone
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="contact_phone_table")
 * @ORM\Entity(repositoryClass="IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository\ContactPhoneRepository")
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactPhone implements ContactPhoneInterface
{
    use ORMBehaviors\Timestampable\Timestampable;

    use PositionTrait;
    use YesOrNoTrait;
    use IdTrait;
    use ShowOnWebsiteTrait;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=false)
     */
    private $phoneNumber;

    /**
     * @var \IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactPhoneType
     *
     * @Gedmo\Versioned
     * @ORM\ManyToOne(targetEntity="IhorDrevetskyi\SupportCenter\ContactBundle\Entity\ContactPhoneType", inversedBy="contactPhones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_phone_type_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $contactPhoneType;

    /**
     * @return ContactPhoneTypeInterface|null
     */
    public function getContactPhoneType(): ?ContactPhoneTypeInterface
    {
        return $this->contactPhoneType;
    }

    /**
     * @param ContactPhoneTypeInterface $contactPhoneType
     */
    public function setContactPhoneType(ContactPhoneTypeInterface $contactPhoneType): void
    {
        $this->contactPhoneType = $contactPhoneType;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phone
     */
    public function setPhoneNumber(string $phone): void
    {
        $this->phoneNumber = $phone;
    }
}
