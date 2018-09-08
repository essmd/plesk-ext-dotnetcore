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
}