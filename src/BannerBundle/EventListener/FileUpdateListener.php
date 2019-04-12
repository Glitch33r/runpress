<?php

namespace BannerBundle\EventListener;

use UploadBundle\Services\FileHandler;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class FileUpdateListener extends \UploadBundle\EventListener\FileUpdateListener
{
    public function __construct(FileHandler $fileHandler)
    {
        parent::__construct($fileHandler, new FileUpdateConfig());
    }
}