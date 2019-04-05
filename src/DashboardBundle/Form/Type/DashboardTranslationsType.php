<?php

namespace DashboardBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
class DashboardTranslationsType extends AbstractType
{
    /**
     * @return string|null
     */
    public function getParent()
    {
        return TranslationsType::class;
    }
}
