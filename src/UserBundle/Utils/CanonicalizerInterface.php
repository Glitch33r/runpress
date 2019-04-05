<?php

namespace UserBundle\Utils;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface CanonicalizerInterface
{
    /**
     * @param string $string
     * @return mixed
     */
    public function canonicalize(string $string);
}
