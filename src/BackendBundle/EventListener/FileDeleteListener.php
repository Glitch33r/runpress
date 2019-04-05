<?php

namespace BackendBundle\EventListener;

use UploadBundle\Services\FileHandler;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class FileDeleteListener extends \UploadBundle\EventListener\FileDeleteListener
{
    public function __construct(FileHandler $fileHandler)
    {
        parent::__construct($fileHandler, new FileUpdateConfig());
    }
}
