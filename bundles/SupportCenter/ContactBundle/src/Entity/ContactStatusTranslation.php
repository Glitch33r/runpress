<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use IhorDrevetskyi\ComponentBundle\Entity\Title\TitleTrait;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use IhorDrevetskyi\ComponentBundle\Entity\Title\TitleInterface;

/**
 * ContactStatusTranslation
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="contact_status_translation_table")
 * @ORM\Entity
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactStatusTranslation implements TitleInterface
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Translatable\Translation;

    use TitleTrait;
}
