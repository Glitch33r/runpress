<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpLinks
 *
 * @ORM\Table(name="wp_links", indexes={@ORM\Index(name="link_visible", columns={"link_visible"})})
 * @ORM\Entity
 */
class WpLinks
{
    /**
     * @var int
     *
     * @ORM\Column(name="link_id", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $linkId;

    /**
     * @var string
     *
     * @ORM\Column(name="link_url", type="string", length=255, nullable=false)
     */
    private $linkUrl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link_name", type="string", length=255, nullable=false)
     */
    private $linkName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link_image", type="string", length=255, nullable=false)
     */
    private $linkImage = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link_target", type="string", length=25, nullable=false)
     */
    private $linkTarget = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link_description", type="string", length=255, nullable=false)
     */
    private $linkDescription = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link_visible", type="string", length=20, nullable=false, options={"default"="Y"})
     */
    private $linkVisible = 'Y';

    /**
     * @var int
     *
     * @ORM\Column(name="link_owner", type="bigint", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $linkOwner = '1';

    /**
     * @var int
     *
     * @ORM\Column(name="link_rating", type="integer", nullable=false)
     */
    private $linkRating = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="link_updated", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $linkUpdated = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="link_rel", type="string", length=255, nullable=false)
     */
    private $linkRel = '';

    /**
     * @var string
     *
     * @ORM\Column(name="link_notes", type="text", length=16777215, nullable=false)
     */
    private $linkNotes;

    /**
     * @var string
     *
     * @ORM\Column(name="link_rss", type="string", length=255, nullable=false)
     */
    private $linkRss = '';

    public function getLinkId(): ?int
    {
        return $this->linkId;
    }

    public function getLinkUrl(): ?string
    {
        return $this->linkUrl;
    }

    public function setLinkUrl(string $linkUrl): self
    {
        $this->linkUrl = $linkUrl;

        return $this;
    }

    public function getLinkName(): ?string
    {
        return $this->linkName;
    }

    public function setLinkName(string $linkName): self
    {
        $this->linkName = $linkName;

        return $this;
    }

    public function getLinkImage(): ?string
    {
        return $this->linkImage;
    }

    public function setLinkImage(string $linkImage): self
    {
        $this->linkImage = $linkImage;

        return $this;
    }

    public function getLinkTarget(): ?string
    {
        return $this->linkTarget;
    }

    public function setLinkTarget(string $linkTarget): self
    {
        $this->linkTarget = $linkTarget;

        return $this;
    }

    public function getLinkDescription(): ?string
    {
        return $this->linkDescription;
    }

    public function setLinkDescription(string $linkDescription): self
    {
        $this->linkDescription = $linkDescription;

        return $this;
    }

    public function getLinkVisible(): ?string
    {
        return $this->linkVisible;
    }

    public function setLinkVisible(string $linkVisible): self
    {
        $this->linkVisible = $linkVisible;

        return $this;
    }

    public function getLinkOwner(): ?int
    {
        return $this->linkOwner;
    }

    public function setLinkOwner(int $linkOwner): self
    {
        $this->linkOwner = $linkOwner;

        return $this;
    }

    public function getLinkRating(): ?int
    {
        return $this->linkRating;
    }

    public function setLinkRating(int $linkRating): self
    {
        $this->linkRating = $linkRating;

        return $this;
    }

    public function getLinkUpdated(): ?\DateTimeInterface
    {
        return $this->linkUpdated;
    }

    public function setLinkUpdated(\DateTimeInterface $linkUpdated): self
    {
        $this->linkUpdated = $linkUpdated;

        return $this;
    }

    public function getLinkRel(): ?string
    {
        return $this->linkRel;
    }

    public function setLinkRel(string $linkRel): self
    {
        $this->linkRel = $linkRel;

        return $this;
    }

    public function getLinkNotes(): ?string
    {
        return $this->linkNotes;
    }

    public function setLinkNotes(string $linkNotes): self
    {
        $this->linkNotes = $linkNotes;

        return $this;
    }

    public function getLinkRss(): ?string
    {
        return $this->linkRss;
    }

    public function setLinkRss(string $linkRss): self
    {
        $this->linkRss = $linkRss;

        return $this;
    }


}
