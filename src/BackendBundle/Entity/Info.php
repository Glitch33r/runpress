<?php

namespace BackendBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\__Call\__CallInterface;
use IhorDrevetskyi\ComponentBundle\Entity\__Call\__CallTrait;
use IhorDrevetskyi\ComponentBundle\Entity\Id\IdInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Id\IdTrait;
use IhorDrevetskyi\ComponentBundle\Entity\Position\PositionInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Position\PositionTrait;
use IhorDrevetskyi\ComponentBundle\Entity\Poster\PosterTrait;
use IhorDrevetskyi\ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteInterface;
use IhorDrevetskyi\ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteTrait;
use IhorDrevetskyi\ComponentBundle\Entity\YesOrNo\YesOrNoInterface;
use IhorDrevetskyi\ComponentBundle\Entity\YesOrNo\YesOrNoTrait;
use IhorDrevetskyi\SeoBundle\Entity\SeoTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Info
 *
 * @Gedmo\Loggable
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="info_table", uniqueConstraints={
@ORM\UniqueConstraint(name="seo_UNIQUE", columns={"seo_id"})
 *     }, indexes={
@ORM\Index(name="seo_idx", columns={"seo_id"}),
@ORM\Index(name="position_idx", columns={"position"}),
@ORM\Index(name="show_on_website_idx", columns={"show_on_website"}),
 *     })
 * @ORM\Entity(repositoryClass="BackendBundle\Entity\Repository\InfoRepository")
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class Info implements YesOrNoInterface, IdInterface, __CallInterface, PositionInterface, ShowOnWebsiteInterface
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Translatable\Translatable;

    use SeoTrait;
    use IdTrait;
    use __CallTrait;
    use YesOrNoTrait;
    use PositionTrait;
    use ShowOnWebsiteTrait;
    use PosterTrait;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="publish_at", type="datetime", nullable=false)
     * @Gedmo\Versioned
     */
    protected $publishAt;

    public function __toString(): string
    {
        return (string)$this->translate()->getTitle();
    }

    /**
     * @return mixed|string
     */
    public function getPublishAt(): \DateTimeInterface
    {
        if (!$this->publishAt) {
            self::setPublishAt(null);
        }

        return $this->publishAt;
    }

    public function setPublishAt($publishAt): void
    {
        if (is_null($publishAt)) {
            $this->publishAt = new \DateTime();
        } else {
            $this->publishAt = $publishAt;
        }
    }
}
