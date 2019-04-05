<?php

namespace DashboardBundle\Entity\Repository;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
interface DashboardRepositoryInterface
{
    /**
     * @param array $dataTable
     * @param array $listElementsForIndex
     * @return mixed
     */
    public function allElementsForIndexDashboard(array $dataTable, array $listElementsForIndex);

    /**
     * @param int $id
     * @return mixed
     */
    public function getElementByIdForDashboardEditOrDeleteFormAction(int $id);
}