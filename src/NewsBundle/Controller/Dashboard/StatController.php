<?php

namespace NewsBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use NewsBundle\Entity\NewsAuthor;

class StatController extends AbstractController
{
	private $em;

	public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function renderTableForHomepage()
    {
    	$authors = $this->em->getRepository(NewsAuthor::class)->getForAdminAStat();

    	return $this->render('@News/dashboard/homepage/table/_table.html.twig', [
    		'authors' => $authors,
    	]);
    }
}