<?php

namespace BackendBundle\Entity;

use ComponentBundle\Entity\PosterAlt\PosterAltTrait;
use ComponentBundle\Entity\Slug\SlugInterface;
use ComponentBundle\Entity\Slug\SlugUniqueTrueTrait;
use ComponentBundle\Entity\Title\TitleInterface;
use ComponentBundle\Entity\Title\TitleTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints as UniqueEntity;

/**
 * VideoTranslation
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="video_translation_table", indexes={
@ORM\Index(name="slug_idx", columns={"slug"}),
 *     })
 * @UniqueEntity\UniqueEntity(fields="slug")
 * @ORM\Entity
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class VideoTranslation implements TitleInterface, SlugInterface
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Translatable\Translation;

    use TitleTrait;
    use SlugUniqueTrueTrait;
}
