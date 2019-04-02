<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpTerms
 *
 * @ORM\Table(name="wp_terms", indexes={@ORM\Index(name="name", columns={"name"}), @ORM\Index(name="slug", columns={"slug"})})
 * @ORM\Entity
 */
class WpTerms
{
    /**
     * @var int
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $termId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=200, nullable=false)
     */
    private $slug = '';

    /**
     * @var int
     *
     * @ORM\Column(name="term_group", type="bigint", nullable=false)
     */
    private $termGroup = '0';

    public function getTermId(): ?int
    {
        return $this->termId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTermGroup(): ?int
    {
        return $this->termGroup;
    }

    public function setTermGroup(int $termGroup): self
    {
        $this->termGroup = $termGroup;

        return $this;
    }


}
