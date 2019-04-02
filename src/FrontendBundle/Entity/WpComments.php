<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpComments
 *
 * @ORM\Table(name="wp_comments", indexes={@ORM\Index(name="comment_author_email", columns={"comment_author_email"}), @ORM\Index(name="comment_approved_date_gmt", columns={"comment_approved", "comment_date_gmt"}), @ORM\Index(name="comment_date_gmt", columns={"comment_date_gmt"}), @ORM\Index(name="comment_post_ID", columns={"comment_post_ID"}), @ORM\Index(name="comment_parent", columns={"comment_parent"})})
 * @ORM\Entity
 */
class WpComments
{
    /**
     * @var int
     *
     * @ORM\Column(name="comment_ID", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentId;

    /**
     * @var int
     *
     * @ORM\Column(name="comment_post_ID", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $commentPostId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_author", type="text", length=255, nullable=false)
     */
    private $commentAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_author_email", type="string", length=100, nullable=false)
     */
    private $commentAuthorEmail = '';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_author_url", type="string", length=200, nullable=false)
     */
    private $commentAuthorUrl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_author_IP", type="string", length=100, nullable=false)
     */
    private $commentAuthorIp = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="comment_date", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $commentDate = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="comment_date_gmt", type="datetime", nullable=false, options={"default"="0000-00-00 00:00:00"})
     */
    private $commentDateGmt = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_content", type="text", length=65535, nullable=false)
     */
    private $commentContent;

    /**
     * @var int
     *
     * @ORM\Column(name="comment_karma", type="integer", nullable=false)
     */
    private $commentKarma = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_approved", type="string", length=20, nullable=false, options={"default"="1"})
     */
    private $commentApproved = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_agent", type="string", length=255, nullable=false)
     */
    private $commentAgent = '';

    /**
     * @var string
     *
     * @ORM\Column(name="comment_type", type="string", length=20, nullable=false)
     */
    private $commentType = '';

    /**
     * @var int
     *
     * @ORM\Column(name="comment_parent", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $commentParent = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="bigint", nullable=false, options={"unsigned"=true})
     */
    private $userId = '0';

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function getCommentPostId(): ?int
    {
        return $this->commentPostId;
    }

    public function setCommentPostId(int $commentPostId): self
    {
        $this->commentPostId = $commentPostId;

        return $this;
    }

    public function getCommentAuthor(): ?string
    {
        return $this->commentAuthor;
    }

    public function setCommentAuthor(string $commentAuthor): self
    {
        $this->commentAuthor = $commentAuthor;

        return $this;
    }

    public function getCommentAuthorEmail(): ?string
    {
        return $this->commentAuthorEmail;
    }

    public function setCommentAuthorEmail(string $commentAuthorEmail): self
    {
        $this->commentAuthorEmail = $commentAuthorEmail;

        return $this;
    }

    public function getCommentAuthorUrl(): ?string
    {
        return $this->commentAuthorUrl;
    }

    public function setCommentAuthorUrl(string $commentAuthorUrl): self
    {
        $this->commentAuthorUrl = $commentAuthorUrl;

        return $this;
    }

    public function getCommentAuthorIp(): ?string
    {
        return $this->commentAuthorIp;
    }

    public function setCommentAuthorIp(string $commentAuthorIp): self
    {
        $this->commentAuthorIp = $commentAuthorIp;

        return $this;
    }

    public function getCommentDate(): ?\DateTimeInterface
    {
        return $this->commentDate;
    }

    public function setCommentDate(\DateTimeInterface $commentDate): self
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    public function getCommentDateGmt(): ?\DateTimeInterface
    {
        return $this->commentDateGmt;
    }

    public function setCommentDateGmt(\DateTimeInterface $commentDateGmt): self
    {
        $this->commentDateGmt = $commentDateGmt;

        return $this;
    }

    public function getCommentContent(): ?string
    {
        return $this->commentContent;
    }

    public function setCommentContent(string $commentContent): self
    {
        $this->commentContent = $commentContent;

        return $this;
    }

    public function getCommentKarma(): ?int
    {
        return $this->commentKarma;
    }

    public function setCommentKarma(int $commentKarma): self
    {
        $this->commentKarma = $commentKarma;

        return $this;
    }

    public function getCommentApproved(): ?string
    {
        return $this->commentApproved;
    }

    public function setCommentApproved(string $commentApproved): self
    {
        $this->commentApproved = $commentApproved;

        return $this;
    }

    public function getCommentAgent(): ?string
    {
        return $this->commentAgent;
    }

    public function setCommentAgent(string $commentAgent): self
    {
        $this->commentAgent = $commentAgent;

        return $this;
    }

    public function getCommentType(): ?string
    {
        return $this->commentType;
    }

    public function setCommentType(string $commentType): self
    {
        $this->commentType = $commentType;

        return $this;
    }

    public function getCommentParent(): ?int
    {
        return $this->commentParent;
    }

    public function setCommentParent(int $commentParent): self
    {
        $this->commentParent = $commentParent;

        return $this;
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


}
