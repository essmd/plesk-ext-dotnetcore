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
    public static function getDomainTabs(pm_Domain $domain, $activeControllerName = null) {
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

            $tab['link'] = self::createLinkForDomain($domain, $tab['controller'], $tab['action']);

            if (strcasecmp($tab['controller'], $activeControllerName) === 0) {
                $tab['active'] = true;
                break;
            }
        }

        return $tabs;
    }

    private static function createLinkForDomain(pm_Domain $domain, $controller, $action) {
        $link = pm_Context::getActionUrl($controller, $action);
        $query = [];

        foreach ([ 'dom_id', 'site_id'] as $param) {
            if (isset($_GET[$param])) {
                $query[$param] = $_GET[$param];
            }
        }

        if (!empty($query)) {
            return $link . '?' . http_build_query($query);
        }

        return $link;
    }
}