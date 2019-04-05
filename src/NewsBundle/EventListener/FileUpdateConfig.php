<?php

namespace NewsBundle\EventListener;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class FileUpdateConfig
{
    public $elements = [
        'News' => ['poster'],
        'NewsAuthor' => ['poster'],
        'NewsElement' => ['img'],
        'NewsGalleryImage' => ['img'],
    ];
}
