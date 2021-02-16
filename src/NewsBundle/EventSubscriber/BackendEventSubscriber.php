<?php

namespace NewsBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DashboardBundle\Event\ListQueryBuilderEvent;
use Ecommerce\Entity\Order;

class BackendEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'dashboard.list.querybuilder' => [
                ['onQueryBuilderEvent'],
            ],
        ];
    }

    public function onQueryBuilderEvent(ListQueryBuilderEvent $event)
    {
        $queryBuilder = $event->getQueryBuilder();
        $user = $event->getUser();

        if ($user->hasRole('ROLE_JOURNALIST')) {
            $queryBuilder
                ->andWhere('q.newsAuthor=:newsAuthor')
                ->setParameter('newsAuthor', $user->getAuthor());
        }
    }
}