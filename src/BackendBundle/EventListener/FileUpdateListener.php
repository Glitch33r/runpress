<?php

namespace BackendBundle\EventListener;

use IhorDrevetskyi\UploadBundle\Services\FileHandler;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class FileUpdateListener extends \IhorDrevetskyi\UploadBundle\EventListener\FileUpdateListener
{
    public function __construct(FileHandler $fileHandler)
    {
        parent::__construct($fileHandler, new FileUpdateConfig());
    }
}
