<?php

namespace NewsBundle\EventListener;

use NewsBundle\Entity\News;
use Symfony\Component\HttpFoundation\RequestStack;
use NewsBundle\Controller\Frontend\NewsController;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * @author Design studio origami <https://origami.ua>
 */

class PostPersistListener
{
	private $newsController;
	private $request;

	public function __construct(NewsController $newsController, RequestStack $requestStack)
	{
		$this->newsController = $newsController;
		$this->request = $requestStack->getCurrentRequest();
	}

    public function UpdateYandexRss(News $entity, LifecycleEventArgs $event)
    {
        $this->newsController->ExportYandexRssAction($this->request);
    }
}