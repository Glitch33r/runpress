<?php

namespace ComponentBundle\Controller\Dashboard;

/**
 * @author Ihor Drevetskyi <ihor.drevetskyi@gmail.com>
 */
trait sidebarLogsTrait
{
    /**
     * @return array|null
     */
    private function sidebarLogs(): ?array
    {
        return self::itemSidebar(
            ['ROLE_LOG'], [], ['dashboard_log'], 'flaticon-exclamation', false, null, null,
            'sidebar.configuration.log', [], 'dashboard_log'
        );
    }
}