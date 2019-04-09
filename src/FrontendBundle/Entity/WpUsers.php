<?php

namespace FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WpUsers
 *
 * @ORM\Table(name="wp_users", indexes={@ORM\Index(name="user_nicename", columns={"user_nicename"}), @ORM\Index(name="user_login_key", columns={"user_login"}), @ORM\Index(name="user_email", columns={"user_email"})})
 * @ORM\Entity
 */
class WpUsers
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_login", type="string", length=60, nullable=false)
     */
    private $userLogin = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_pass", type="string", length=255, nullable=false)
     */
    private $userPass = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_nicename", type="string", length=50, nullable=false)
     */
    private $userNicename = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     */
    private $userEmail = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_url", type="string", length=100, nullable=false)
     */
    private $userUrl = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="user_registered", type="datetime", nullable=false)
     */
    private $userRegistered = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="user_activation_key", type="string", length=255, nullable=false)
     */
    private $userActivationKey = '';

    /**
     * @var int
     *
     * @ORM\Column(name="user_status", type="integer", nullable=false)
     */
    private $userStatus = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=250, nullable=false)
     */
    private $displayName = '';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserLogin(): ?string
    {
        return $this->userLogin;
    }

    public function setUserLogin(string $userLogin): self
    {
        $this->userLogin = $userLogin;

        return $this;
    }

    public function getUserPass(): ?string
    {
        return $this->userPass;
    }

    public function setUserPass(string $userPass): self
    {
        $this->userPass = $userPass;

        return $this;
    }

    public function getUserNicename(): ?string
    {
        return $this->userNicename;
    }

    public function setUserNicename(string $userNicename): self
    {
        $this->userNicename = $userNicename;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserUrl(): ?string
    {
        return $this->userUrl;
    }

    public function setUserUrl(string $userUrl): self
    {
        $this->userUrl = $userUrl;

        return $this;
    }

    public function getUserRegistered(): ?\DateTimeInterface
    {
        return $this->userRegistered;
    }

    public function setUserRegistered(\DateTimeInterface $userRegistered): self
    {
        $this->userRegistered = $userRegistered;

        return $this;
    }

    public function getUserActivationKey(): ?string
    {
        return $this->userActivationKey;
    }

    public function setUserActivationKey(string $userActivationKey): self
    {
        $this->userActivationKey = $userActivationKey;

        return $this;
    }

    public function getUserStatus(): ?int
    {
        return $this->userStatus;
    }

    public function setUserStatus(int $userStatus): self
    {
        $this->userStatus = $userStatus;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }


}
