<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpOptions
 *
 * @ORM\Table(name="wp_options", uniqueConstraints={@ORM\UniqueConstraint(name="option_name", columns={"option_name"})})
 * @ORM\Entity
 */
class WpOptions
{
    /**
     * @var int
     *
     * @ORM\Column(name="option_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $optionId;

    /**
     * @var string
     *
     * @ORM\Column(name="option_name", type="string", length=191, nullable=false)
     */
    private $optionName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="option_value", type="text", length=0, nullable=false)
     */
    private $optionValue;

    /**
     * @var string
     *
     * @ORM\Column(name="autoload", type="string", length=20, nullable=false, options={"default"="yes"})
     */
    private $autoload = 'yes';

    public function getOptionId(): ?int
    {
        return $this->optionId;
    }

    public function getOptionName(): ?string
    {
        return $this->optionName;
    }

    public function setOptionName(string $optionName): self
    {
        $this->optionName = $optionName;

        return $this;
    }

    public function getOptionValue(): ?string
    {
        return $this->optionValue;
    }

    public function setOptionValue(string $optionValue): self
    {
        $this->optionValue = $optionValue;

        return $this;
    }

    public function getAutoload(): ?string
    {
        return $this->autoload;
    }

    public function setAutoload(string $autoload): self
    {
        $this->autoload = $autoload;

        return $this;
    }


}
