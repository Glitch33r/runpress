<?php

namespace NewsBundle\Entity;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait NewsAwareTrait
{
    /**
     * @return NewsInterface
     */
    public function getNews(): NewsInterface
    {
        return $this->news;
    }

    /**
     * @param NewsInterface $news
     */
    public function setNews(?NewsInterface $news): void
    {
        $this->news = $news;
    }
}