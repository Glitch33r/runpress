<?php

namespace FrontendBundle\Controller;

use NewsBundle\Entity\News;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class SearchController extends \ComponentBundle\Controller\Frontend\SearchController
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
