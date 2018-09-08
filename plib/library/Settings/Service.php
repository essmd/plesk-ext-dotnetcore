<?php

class Modules_Dotnetcore_Settings_Service
{
    private $_name;
    private $_entryPoint;
    private $_workingDirectory;
    private $_environment;

    public function __construct(array $options) {
        $this->_name = $options['name'];
        $this->_entryPoint = $options['entryPoint'];
        $this->_environment = $options['environment'];
        $this->_workingDirectory = $options['workingDirectory'];
    }

    public function getName() {
        return $this->_name;
    }

    public function getEntryPoint() {
        return $this->_entryPoint;
    }

    public function getWorkingDirectory() {
        return $this->_workingDirectory;
    }

    public function getEnvironment() {
        return $this->_environment;
    }

    public function generateServiceFileContent($user) {
        
        // unit
        $unit = $this->_generateServiceFileSectionContent('Unit', [
            'Description' => 'The .NET Core App ' . $this->_name
        ]);

        // service
        $runtimePath = '/usr/bin/dotnet';
        $serviceEnvironment = 'ASPNETCORE_ENVIRONMENT=' . $this->_environment;
        $serviceWorkingDirectory = $this->_workingDirectory;
        $serviceExecStart = $runtimePath . ' ' . $serviceWorkingDirectory . DIRECTORY_SEPARATOR . $this->_entryPoint;
        $service = $this->_generateServiceFileSectionContent('Service', [
            'WorkingDirectory' => $serviceWorkingDirectory,
            'ExecStart' =>  $serviceExecStart,
            'Restart' => 'always',
            'RestartSec' => 10,
            'SyslogIdentifier' => $this->_name,
            'User' => $user,
            'Environment' => $serviceEnvironment
        ]);

        // install
        $install = $this->_generateServiceFileSectionContent('Install', [
            'WantedBy' => 'multi-user.target'
        ]);

        return implode(PHP_EOL . PHP_EOL, [ $unit, $service, $install ]);
    }

    public function _generateServiceFileSectionContent($section, $data) {
        $lines = [];
        foreach ($data as $key => $value) {
            $lines[] = $key . '=' . $value;
        }
        
        $content = implode(PHP_EOL, $lines);
        return '[' . $section . ']' . PHP_EOL . $content;
    }
}