<?php

namespace DashboardBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface DashboardControllerInterface
{
    /**
     * Главная страница
     * @return Response
     */
    public function indexAction(): Response;
}