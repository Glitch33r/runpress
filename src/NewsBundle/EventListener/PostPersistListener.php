<?php

namespace NewsBundle\EventListener;

use NewsBundle\Entity\News;
use Symfony\Component\HttpFoundation\RequestStack;
use NewsBundle\Controller\Frontend\NewsController;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @author Design studio origami <https://origami.ua>
 */

class PostPersistListener
{
	private $newsController;
	private $request;
	private $authChecker;

	public function __construct(NewsController $newsController, RequestStack $requestStack, AuthorizationCheckerInterface $authChecker)
	{
		$this->newsController = $newsController;
		$this->request = $requestStack->getCurrentRequest();
		$this->authChecker = $authChecker;
	}

    public function UpdateYandexRss(News $entity, LifecycleEventArgs $event)
    {
    	if($this->authChecker->isGranted('ROLE_DEVELOPER'))
        	$this->newsController->ExportYandexRssAction($this->request);
    }
}