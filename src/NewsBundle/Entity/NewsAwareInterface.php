<?php

namespace NewsBundle\Entity;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface NewsAwareInterface
{
    /**
     * @return NewsInterface
     */
    public function getNews(): NewsInterface;

    /**
     * @param NewsInterface $news
     */
    public function setNews(?NewsInterface $news): void;
}