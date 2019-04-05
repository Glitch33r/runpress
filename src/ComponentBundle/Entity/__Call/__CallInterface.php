<?php

namespace ComponentBundle\Entity\__Call;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface __CallInterface
{
    /**
     * @param $method
     * @param $arguments
     * @return mixed|null
     */
    public function __call($method, $arguments);
}
