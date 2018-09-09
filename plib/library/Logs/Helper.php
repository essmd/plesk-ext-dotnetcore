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
        /*
         * EXAMPLE OF LOG OUTPUT:

         -- Logs begin at Thu 2018-09-06 22:51:06 CEST. --
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: info: Microsoft.AspNetCore.DataProtection.KeyManagement.XmlKeyManager[58]
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: Creating key {00000000-0000-0000-0000-d9b836b4f65b} with creation date 2018-09-08 19:44:51Z, activation date 2018-09-08 19:44:51Z, and expiration date 2018-12-07 19:44:51Z.
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: warn: Microsoft.AspNetCore.DataProtection.KeyManagement.XmlKeyManager[35]
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: No XML encryptor configured. Key {00000000-0000-0000-0000-d9b836b4f65b} may be persisted to storage in unencrypted form.
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: info: AppNamespace.AppName.Scheduling.ScheduledServiceHostService[0]
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: Scheduled service AppNamespace.AppName.Services.ScheduledTransactionsHostedService. Next occurence: 09/08/2018 19:45:00 +00:00
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: Hosting environment: Production
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: Content root path: /var/www/vhosts/domain.tld/htdocs
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: Now listening on: http://localhost:5000
        Sep 08 21:44:51 domain.tld syslog-identifier-from-service-file[21204]: Application started. Press Ctrl+C to shut down.

        */


        $entry = new stdClass();
        $entry->timestamp = time();
        $entry->type = 'error';
        $entry->message = 'There was an error';

        return [ $entry ];
    }

    public static function getLogsForService($serviceName, $count = 15) {
        $args = [ $serviceName, $count ];
        $result = pm_ApiCli::callSbin('read-service-log', $args, pm_ApiCli::RESULT_STDOUT);

        return $result;
    }

    public static function getLogEntriesForService($serviceName, $count = 15) {
        $json = self::getLogsForService($serviceName, $count);
        $entries = self::_createLogEntriesFromJsonLog($json);

        return $entries;
    }

    private static function _createLogEntriesFromJsonLog($jsonLines) {
        if (empty($jsonLines)) {
            return [];
        }

        $entries = [];
        $lines = explode(PHP_EOL, trim($jsonLines));

        foreach ($lines as $line) {
            $line = json_decode($line, true);
            if (!$line) {
                continue;
            }

            $priority = $line['PRIORITY'];
            $priority = self::_normalizeLogPriority($priority);

            $message = $line['MESSAGE'];
            $message = self::_normalizeLogMessage($message);

            $entry = new stdClass();
            $entry->timestamp = $line['__REALTIME_TIMESTAMP'] / 1000000;
            $entry->type = $priority;
            $entry->message = $message;

            $entries[] = $entry;
        }

        return $entries;
    }

    private static function _normalizeLogPriority($priority) {
        if (!is_numeric($priority)) {
            return (string)$priority;
        }

        switch ((int)$priority) {
            case 1: return 'alert';
            case 2: return 'critical';
            case 3: return 'error';
            case 4: return 'warning';
            case 5: return 'notice';
            case 6: return 'info';
            case 7: return 'debug';
        }

        return (string)$priority;
    }

    private static function _normalizeLogMessage($message) {
        if (is_array($message)) {
            $messageAsUnicodeChars = $message;
            $message = '';

            foreach ($messageAsUnicodeChars as $char) {
                $message = $message . chr((int)$char);
            }
        }

        // remove ANSI codes/sequences (terminal colors)
        $message = (string)$message;
        $message = preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', $message);
        
        return $message;
    }
}