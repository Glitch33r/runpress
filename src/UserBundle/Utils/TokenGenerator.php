<?php

namespace UserBundle\Utils;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
