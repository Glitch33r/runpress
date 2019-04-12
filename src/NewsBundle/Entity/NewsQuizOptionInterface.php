<?php

namespace NewsBundle\Entity;

use ComponentBundle\Entity\Id\IdInterface;
use ComponentBundle\Entity\__Call\__CallInterface;
use ComponentBundle\Entity\YesOrNo\YesOrNoInterface;
use ComponentBundle\Entity\Position\PositionInterface;
use ComponentBundle\Entity\ShowOnWebsite\ShowOnWebsiteInterface;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface NewsQuizOptionInterface extends IdInterface, ShowOnWebsiteInterface, YesOrNoInterface, __CallInterface,
    PositionInterface
{
    /**
     * @return int
     */
    public function getVotes(): int;

    /**
     * @param int $votes
     */
    public function setVotes(int $votes): void;

    /**
     * @return NewsQuizInterface
     */
    public function getQuiz(): NewsQuizInterface;

    /**
     * @param NewsQuizInterface $quiz
     */
    public function setQuiz(NewsQuizInterface $quiz): void;
}