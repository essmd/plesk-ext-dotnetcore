<?php

class Modules_Dotnetcore_Common_TabsHelper
{
    /**
     * getDomainTabs
     *
     * Generate the tabs displayed in the domain details
     *
     * @return array
     */
    public static function getDomainTabs($controller = null) {
        $tabs = [
            [
                'title' => pm_Locale::lmsg('pageDomainTabTitle'),
                'controller' => 'index',
                'action' => 'index'
            ],
            [
                'title' => pm_Locale::lmsg('pageLogsTabTitle'),
                'controller' => 'logs',
                'action' => 'index'
            ]
        ];

        foreach ($tabs as &$tab) {
            if (!isset($tab['controller'])) {
                continue;
            }

            if (strcasecmp($tab['controller'], $controller) === 0) {
                $tab['active'] = true;
                break;
            }
        }

        return $tabs;
    }
}