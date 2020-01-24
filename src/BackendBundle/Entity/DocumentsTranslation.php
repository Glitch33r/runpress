<?php

namespace BackendBundle\Entity;

use ComponentBundle\Entity\Title\TitleTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * DocumentsTranslation
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="documents_translation_table")
 * @ORM\Entity
 */
class DocumentsTranslation
{
    use Translation;

    use TitleTrait;
}
