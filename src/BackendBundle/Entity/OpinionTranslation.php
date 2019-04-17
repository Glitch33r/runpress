<?php

namespace BackendBundle\Entity;

use \ComponentBundle\Entity\Description\DescriptionInterface;
use \ComponentBundle\Entity\Description\DescriptionTrait;
use \ComponentBundle\Entity\ShortDescription\ShortDescriptionTrait;
use \ComponentBundle\Entity\Slug\SlugInterface;
use \ComponentBundle\Entity\Slug\SlugUniqueTrueTrait;
use \ComponentBundle\Entity\Title\TitleInterface;
use \ComponentBundle\Entity\Title\TitleTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use \ComponentBundle\Entity\PosterAlt\PosterAltTrait;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints as UniqueEntity;

/**
 * OpinionTranslation
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="opinion_translation_table", indexes={
@ORM\Index(name="slug_idx", columns={"slug"}),
 *     })
 * @UniqueEntity\UniqueEntity(fields="slug")
 * @ORM\Entity
 * @author Design studio origami <https://origami.ua>
 */
class OpinionTranslation implements TitleInterface, SlugInterface, DescriptionInterface
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Translatable\Translation;

    use TitleTrait;
    use SlugUniqueTrueTrait;
    use ShortDescriptionTrait;
    use DescriptionTrait;
    use PosterAltTrait;
}
