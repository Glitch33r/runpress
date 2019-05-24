<?php

namespace BackendBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * @author Design studio origami <https://origami.ua>
 */
final class MigrationController extends Controller
{
	public function createAction()
	{
	    $application = new Application($this->get('kernel'));
	    $application->setAutoExit(false);

	    $input = new ArrayInput(array(
	       'command' => 'make:migration',
	    ));

	    $output = new BufferedOutput();
	    $application->run($input, $output);

	    echo '<pre>'.$output->fetch();
	    exit;
	}

	public function runAction()
	{
	    $application = new Application($this->get('kernel'));
	    $application->setAutoExit(false);

	    $input = new ArrayInput(array(
	       'command' => 'doctrine:migrations:migrate',
	    ));
	    $input->setInteractive(false);

	    $output = new BufferedOutput();
	    $application->run($input, $output);

	    echo '<pre>'.$output->fetch();
	    exit;
	}
}