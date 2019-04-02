<?php

namespace FrontendBundle\Controller;

use IhorDrevetskyi\NewsBundle\Entity\News;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
final class SearchController extends \IhorDrevetskyi\ComponentBundle\Controller\Frontend\SearchController
{
    /**
     * @return array
     */
    public function getEntitiesForSearch(): array
    {
        $results = [
            'News' => [
                'entity' => News::class,
                'fields' => [
                    'title' => [
                        'is_translate' => true,
                        'field' => 'title'
                    ]
                ],
                'sort' => [
                    'field' => 'publishAt',
                    'sort' => 'DESC'
                ]
            ]
        ];

        return $results;
    }
}
