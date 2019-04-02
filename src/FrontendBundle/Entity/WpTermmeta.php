<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpTermmeta
 *
 * @ORM\Table(name="wp_termmeta", indexes={@ORM\Index(name="meta_key", columns={"meta_key"}), @ORM\Index(name="term_id", columns={"term_id"})})
 * @ORM\Entity
 */
class WpTermmeta
{
    /**
     * @var int
     *
     * @ORM\Column(name="meta_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $metaId;

    /**
     * @var int
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $termId = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="meta_key", type="string", length=255, nullable=true)
     */
    private $metaKey;

    /**
     * @var string|null
     *
     * @ORM\Column(name="meta_value", type="text", length=0, nullable=true)
     */
    private $metaValue;

    public function getMetaId(): ?int
    {
        return $this->metaId;
    }

    public function getTermId(): ?int
    {
        return $this->termId;
    }

    public function setTermId(int $termId): self
    {
        $this->termId = $termId;

        return $this;
    }

    public function getMetaKey(): ?string
    {
        return $this->metaKey;
    }

    public function setMetaKey(?string $metaKey): self
    {
        $this->metaKey = $metaKey;

        return $this;
    }

    public function getMetaValue(): ?string
    {
        return $this->metaValue;
    }

    public function setMetaValue(?string $metaValue): self
    {
        $this->metaValue = $metaValue;

        return $this;
    }


}
