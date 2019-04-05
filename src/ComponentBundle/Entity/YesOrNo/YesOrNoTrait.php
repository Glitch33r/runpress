<?php

namespace ComponentBundle\Entity\YesOrNo;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait YesOrNoTrait
{
    /**
     * @return array
     */
    public static function yesOrNo(): array
    {
        return [
            self::YES => "form.yes",
            self::NO => "form.no"
        ];
    }

    /**
     * @return array
     */
    public static function yesOrNoForm(): array
    {
        return [
            "form.yes" => self::YES,
            "form.no" => self::NO,
        ];
    }
}
