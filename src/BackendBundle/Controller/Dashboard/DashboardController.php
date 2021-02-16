<?php

namespace BackendBundle\Controller\Dashboard;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class DashboardController extends \DashboardBundle\Controller\DashboardController
{
	protected $em = null;

    public function __construct(EntityManagerInterface $em)
    {
    	parent::__construct();
        $this->em = $em;
    }
    
	public function ajaxCheckboxAction(Request $request)
    {
        $entity = $this->em->getRepository($request->request->get('entity'))->find((int)$request->request->get('id'));
        
        if($entity) {
            $method = "set" . ucfirst($request->request->get('field'));
            $entity->$method($request->request->get('checked') == 'true');

            $this->em->persist($entity);
            $this->em->flush();
        }

        exit();
    }

    public function indexAction(): Response
    {
        return $this->render('@Backend/templates/1/homepage/index.html.twig', [
            'templateNumber' => 1,
        ]);
    }
}