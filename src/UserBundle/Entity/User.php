<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ComponentBundle\Entity\Id\IdTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use ComponentBundle\Entity\Img\ImgTrait;
use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Doctrine\Common\Collections\ArrayCollection;
use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;
use NewsBundle\Entity\NewsAuthor;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as UniqueEntity;

/**
 * User
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="`user_table`", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"}),
 *     @ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"}),
 *     @ORM\UniqueConstraint(name="username_canonical_UNIQUE", columns={"username_canonical"}),
 *     @ORM\UniqueConstraint(name="email_canonical_UNIQUE", columns={"email_canonical"})
 * }, indexes={
 *     @ORM\Index(name="email_idx", columns={"email"}),
 *     @ORM\Index(name="email_canonical_idx", columns={"email_canonical"})
 * })
 * @UniqueEntity\UniqueEntity(fields="email")
 * @ORM\Entity(repositoryClass="UserBundle\Entity\Repository\UserRepository")
 * @author Design studio origami <https://origami.ua>
 */
class User implements UserInterface
{
    use ORMBehaviors\Timestampable\Timestampable;
    use IdTrait;
    use ImgTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Gedmo\Versioned
     */
    private $username;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="username_canonical", type="string", length=255, nullable=true, unique=true)
     */
    protected $usernameCanonical;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Gedmo\Versioned
     */
    private $email;

    /**
     * @var string|null
     *
     * @Gedmo\Versioned
     * @Assert\Email()
     * @ORM\Column(name="email_canonical", type="string", length=255, nullable=true, unique=true)
     */
    protected $emailCanonical;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="locale", type="string", length=2, nullable=false)
     */
    private $locale = 'ru';

    /**
     * Random data that is used as an additional input to a function that hashes a password.
     *
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * Password before encryption. Used for model validation. Must not be persisted.
     *
     * @var string|null
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * We need at least one role to be able to authenticate
     *
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     * @Gedmo\Versioned
     */
    private $roles = [UserInterface::DEFAULT_ROLE];

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="integer", nullable=false)
     * @Gedmo\Versioned
     */
    private $enabled = YesOrNoInterface::NO;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="integer", nullable=false)
     * @Gedmo\Versioned
     */
    protected $locked = YesOrNoInterface::NO;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    protected $expiresAt;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    protected $credentialsExpireAt;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="verified_at", type="datetime", nullable=true)
     */
    protected $verifiedAt;

    /**
     * Random string sent to the user email address in order to verify it
     *
     * @var string|null
     *
     * @ORM\Column(name="email_verification_token", type="string", length=255, nullable=true)
     */
    protected $emailVerificationToken;

    /**
     * Random string sent to the user email address in order to verify the password resetting request
     *
     * @var string|null
     *
     * @ORM\Column(name="password_reset_token", type="string", length=255, nullable=true)
     */
    protected $passwordResetToken;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\UserOAuth", mappedBy="user", cascade={"persist","remove"}, orphanRemoval=true)
     */
    private $oauthAccounts;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\OneToOne(targetEntity="NewsBundle\Entity\NewsAuthor", mappedBy="user", cascade={"persist","remove"})
     */
    private $author;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->oauthAccounts = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): ?string
    {
        return (string)$this->getUsername();
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsernameCanonical(): ?string
    {
        return $this->usernameCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsernameCanonical(?string $usernameCanonical): void
    {
        $this->usernameCanonical = $usernameCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->setUsername($email);
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailCanonical(): ?string
    {
        return $this->emailCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical(?string $emailCanonical): void
    {
        $this->emailCanonical = $emailCanonical;
    }

    /**
     * {@inheritdoc}
     */
    public function setSalt(?string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlainPassword(?string $password): void
    {
        $this->plainPassword = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function setRoles(array $roles): void
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addRole(string $role): void
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function removeRole(string $role): void
    {
        $key = array_search(strtoupper($role), $this->roles, true);

        if (false !== $key) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = (bool)$enabled;
    }

    /**
     *
     */
    public function enable(): void
    {
        $this->enabled = true;
    }

    /**
     *
     */
    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocked(bool $locked): void
    {
        $this->locked = $locked;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocked(): bool
    {
        return $this->locked;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked(): bool
    {
        return !$this->locked;
    }

    /**
     * {@inheritdoc}
     */
    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setExpiresAt(?\DateTimeInterface $date): void
    {
        $this->expiresAt = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired(): bool
    {
        return !$this->hasExpired($this->credentialsExpireAt);
    }

    /**
     * @param \DateTimeInterface|null $date
     * @return bool
     * @throws \Exception
     */
    protected function hasExpired(?\DateTimeInterface $date): bool
    {
        return null !== $date && new \DateTime() >= $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired(): bool
    {
        return !$this->hasExpired($this->expiresAt);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentialsExpireAt(): ?\DateTimeInterface
    {
        return $this->credentialsExpireAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCredentialsExpireAt(?\DateTimeInterface $date): void
    {
        $this->credentialsExpireAt = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastLogin(?\DateTimeInterface $time): void
    {
        $this->lastLogin = $time;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmailVerificationToken(): ?string
    {
        return $this->emailVerificationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailVerificationToken(?string $verificationToken): void
    {
        $this->emailVerificationToken = $verificationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordResetToken(?string $passwordResetToken): void
    {
        $this->passwordResetToken = $passwordResetToken;
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordRequestNonExpired($ttl): bool
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
            $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordRequestedAt(): ?\DateTimeInterface
    {
        return $this->passwordRequestedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordRequestedAt(?\DateTimeInterface $date): void
    {
        $this->passwordRequestedAt = $date;
    }

    /**
     * {@inheritdoc}
     */
    public function isVerified(): bool
    {
        return null !== $this->verifiedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getVerifiedAt(): ?\DateTimeInterface
    {
        return $this->verifiedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setVerifiedAt(?\DateTimeInterface $verifiedAt): void
    {
        $this->verifiedAt = $verifiedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getOAuthAccounts(): Collection
    {
        return $this->oauthAccounts;
    }

    /**
     * {@inheritdoc}
     */
    public function getOAuthAccount(string $provider): ?UserOAuthInterface
    {
        if ($this->oauthAccounts->isEmpty()) {
            return null;
        }

        $filtered = $this->oauthAccounts->filter(function (UserOAuthInterface $oauth) use ($provider): bool {
            return $provider === $oauth->getProvider();
        });

        if ($filtered->isEmpty()) {
            return null;
        }

        return $filtered->current();
    }

    /**
     * {@inheritdoc}
     */
    public function addOAuthAccount(UserOAuthInterface $oauth): void
    {
        if (!$this->oauthAccounts->contains($oauth)) {
            $this->oauthAccounts->add($oauth);
            $oauth->setUser($this);
        }
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phone
     */
    public function setPhoneNumber(?string $phone): void
    {
        $this->phoneNumber = $phone;
    }

    public function getAuthor(): ?NewsAuthor
    {
        return $this->author;
    }

    public function setAuthor(?NewsAuthor $author): self
    {
        $this->author = $author;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $author === null ? null : $this;
        if ($newUser !== $author->getUser()) {
            $author->setUser($newUser);
        }

        return $this;
    }

    /**
     * The serialized data have to contain the fields used by the equals method and the username.
     *
     * @return string
     */
    public function serialize(): ?string
    {
        return serialize([
            $this->password,
            $this->salt,
            $this->username,
            $this->enabled,
            $this->locked,
            $this->id,
            $this->email
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized): void
    {
        $data = unserialize($serialized);
        // add a few extra elements in the array to ensure that we have enough keys when unserializing
        // older data which does not include all properties.
        $data = array_merge($data, array_fill(0, 2, null));

        [
            $this->password,
            $this->salt,
            $this->username,
            $this->enabled,
            $this->locked,
            $this->id,
            $this->email
        ] = $data;
    }
}