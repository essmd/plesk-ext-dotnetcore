<?php

class Modules_Dotnetcore_Services_File
{
    const SERVICE_FILE_FORMAT = 'dotnetcore-%s.service';

    public static function create(pm_Domain $domain, Modules_Dotnetcore_Settings_Service $service) {
        $fileName = self::createServiceFileName($domain);
        $fileContent = self::_createServiceFileContent($service);

        // TODO: Write *.service file to /etc/systemd/system
    }

    public static function register(pm_Domain $domain) {
        $fileName = self::createServiceFileName($domain);

        // TODO: Register the *.service file with systemd
    }

    public static function unregister(pm_Domain $domain) {
        $fileName = self::createServiceFileName($domain);

        // TODO: Unregister the service file for the given domain
    }

    public static function destroy(pm_Domain $domain) {
        $fileName = self::createServiceFileName($domain);
        
        // TODO: Destroy the service file for the given domain
    }

    public static function createServiceFileName(pm_Domain $domain) {
        $format = self::SERVICE_FILE_FORMAT;
        $domainIdentifier = (string)$domain->getId();

        return sprintf($format, $domainIdentifier);
    }

    public function createServiceFileContent(Modules_Dotnetcore_Settings_Service $service) {
        if ($service->isValid() !== true) {
            return null;
        }
        
        // unit
        $unit = self::_createServiceFileSectionContent('Unit', [
            'Description' => 'The .NET Core App ' . $service->getName()
        ]);

        // service
        $runtimePath = '/usr/bin/dotnet';
        $serviceEnvironment = 'ASPNETCORE_ENVIRONMENT=' . $service->getEnvironment();
        $serviceWorkingDirectory = $service->getWorkingDirectory();
        $serviceExecStart = $runtimePath . ' ' . $serviceWorkingDirectory . DIRECTORY_SEPARATOR . $service->getEntryPoint();
        $service = self::_createServiceFileSectionContent('Service', [
            'WorkingDirectory' => $serviceWorkingDirectory,
            'ExecStart' =>  $serviceExecStart,
            'Restart' => 'always',
            'RestartSec' => 10,
            'SyslogIdentifier' => $service->getName(),
            'User' => $service->getUser(),
            'Environment' => $serviceEnvironment
        ]);

        // install
        $install = self::_createServiceFileSectionContent('Install', [
            'WantedBy' => 'multi-user.target'
        ]);

        return implode(PHP_EOL . PHP_EOL, [ $unit, $service, $install ]);
    }

    public static function _createServiceFileSectionContent($section, $data) {
        $lines = [];
        foreach ($data as $key => $value) {
            $lines[] = $key . '=' . $value;
        }
        
        $content = implode(PHP_EOL, $lines);
        return '[' . $section . ']' . PHP_EOL . $content;
    }
}