<?php

class Modules_Dotnetcore_Logs_Helper
{
    /**
     * _getServiceLogList
     *
     * Generates the list used for listAction()
     *
     * @return pm_View_List_Simple
     */
    public static function getServiceLogEntries() {
        $entry = new stdClass();
        $entry->timestamp = time();
        $entry->type = 'error';
        $entry->message = 'There was an error';

        return [ $entry ];
    }
}