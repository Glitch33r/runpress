<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpCommentmeta
 *
 * @ORM\Table(name="wp_commentmeta", indexes={@ORM\Index(name="meta_key", columns={"meta_key"}), @ORM\Index(name="comment_id", columns={"comment_id"})})
 * @ORM\Entity
 */
class WpCommentmeta
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
     * @ORM\Column(name="comment_id", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $commentId = '0';

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

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function setCommentId(int $commentId): self
    {
        $this->commentId = $commentId;

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
