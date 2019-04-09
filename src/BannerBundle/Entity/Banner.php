<?php

namespace BannerBundle\Entity;

use ComponentBundle\Entity\Link\LinkInterface;
use ComponentBundle\Entity\Link\LinkTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use ComponentBundle\Entity\Id\IdTrait;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteTrait;
use ComponentBundle\Entity\Id\IdInterface;
use ComponentBundle\Entity\Img\ImgTrait;
use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;
use ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteInterface;


/**
 * Banner
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="banner_table")
 * @ORM\Entity(repositoryClass="BannerBundle\Entity\Repository\BannerRepository")
 */
class Banner implements YesOrNoInterface, IdInterface, ShowOnWebsiteInterface, LinkInterface
{
    use ORMBehaviors\Timestampable\Timestampable;
    use IdTrait;
    use ShowOnWebsiteTrait;
    use ImgTrait;
    use LinkTrait;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="type", type="text", nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @Gedmo\Versioned
     * @ORM\Column(name="page", type="text", nullable=false)
     */
    private $page;

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPage(): ?string
    {
        return $this->page;
    }

    /**
     * @param string $page
     */
    public function setPage(?string $page): void
    {
        $this->page = $page;
    }

}