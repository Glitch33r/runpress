<?php

namespace UserBundle\Utils;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generateToken(): string;
}
