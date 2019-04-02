<?php

namespace BackendBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\Description\DescriptionInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Description\DescriptionTrait;
use IhorDrevetskyi\ComponentBundle\Entity\ShortDescription\ShortDescriptionTrait;
use IhorDrevetskyi\ComponentBundle\Entity\Slug\SlugInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Slug\SlugUniqueTrueTrait;
use IhorDrevetskyi\ComponentBundle\Entity\Title\TitleInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Title\TitleTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use IhorDrevetskyi\ComponentBundle\Entity\PosterAlt\PosterAltTrait;
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
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
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
