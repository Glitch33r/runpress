<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpUsermeta
 *
 * @ORM\Table(name="wp_usermeta", indexes={@ORM\Index(name="meta_key", columns={"meta_key"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class WpUsermeta
{
    /**
     * @var int
     *
     * @ORM\Column(name="umeta_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $umetaId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $userId = '0';

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

    public function getUmetaId(): ?int
    {
        return $this->umetaId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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
