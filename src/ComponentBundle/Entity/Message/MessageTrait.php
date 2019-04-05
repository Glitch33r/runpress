<?php

namespace ComponentBundle\Entity\Message;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait MessageTrait
{
    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @Assert\NotBlank()
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
