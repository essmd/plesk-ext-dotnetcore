<?php

class Modules_Dotnetcore_Settings_Service
{
    private $_name;
    private $_user;
    private $_entryPoint;
    private $_workingDirectory;
    private $_environment;

    public function __construct(array $options) {
        $this->_name = isset($options['name']) ? $options['name'] : null;
        $this->_user = isset($options['user']) ? $options['user'] : null;
        $this->_entryPoint = isset($options['entryPoint']) ? $options['entryPoint'] : null;
        $this->_environment = isset($options['environment']) ? $options['environment'] : null;
        $this->_workingDirectory = isset($options['workingDirectory']) ? $options['workingDirectory'] : null;
    }

    public function getName() {
        return $this->_name;
    }

    public function getUser() {
        return $this->_user;
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

    public function isValid() {
        if (empty($this->_name)) { return false; }
        if (empty($this->_user)) { return false; }
        if (empty($this->_entryPoint)) { return false; }
        if (empty($this->_environment)) { return false; }
        if (empty($this->_workingDirectory)) { return false; }

        return true;
    }
}