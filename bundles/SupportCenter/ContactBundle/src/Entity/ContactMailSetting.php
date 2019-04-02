<?php

namespace IhorDrevetskyi\SupportCenter\ContactBundle\Entity;

use IhorDrevetskyi\ComponentBundle\Entity\__Call\__CallTrait;
use IhorDrevetskyi\ComponentBundle\Entity\__Call\__CallInterface;;
use IhorDrevetskyi\ComponentBundle\Entity\Id\IdInterface;
use IhorDrevetskyi\ComponentBundle\Entity\Id\IdTrait;
use IhorDrevetskyi\ComponentBundle\Entity\MailSetting\MailSettingInterface;
use IhorDrevetskyi\ComponentBundle\Entity\MailSetting\MailSettingTrait;
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
