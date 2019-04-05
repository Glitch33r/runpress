<?php

namespace DashboardBundle\Utils;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface DashboardManagerInterface
{
    /**
     * DashboardManagerInterface constructor.
     * @param RequestStack $request_stack
     * @param PaginatorInterface $paginator
     */
    public function __construct(RequestStack $request_stack, PaginatorInterface $paginator);

    /**
     * @param $elements
     * @param array $configForIndex
     * @param array $dataTable
     * @return mixed
     */
    public function helperForIndexDashboard($elements, array $configForIndex, array $dataTable);
}