<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use ComponentBundle\Entity\__Call\__CallTrait;
use ComponentBundle\Entity\__Call\__CallInterface;;
use ComponentBundle\Entity\Id\IdInterface;
use ComponentBundle\Entity\Id\IdTrait;
use ComponentBundle\Entity\MailSetting\MailSettingInterface;
use ComponentBundle\Entity\MailSetting\MailSettingTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ContactMailSetting
 *
 * @Gedmo\Loggable
 * @ORM\Table(name="contact_mail_setting_table")
 * @ORM\Entity(repositoryClass="IhorDrevetskyi\SupportCenter\ContactBundle\Entity\Repository\ContactMailSettingRepository")
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class ContactMailSetting implements MailSettingInterface, __CallInterface, IdInterface
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Translatable\Translatable;

    use MailSettingTrait;
    use IdTrait;
    use __CallTrait;
}
