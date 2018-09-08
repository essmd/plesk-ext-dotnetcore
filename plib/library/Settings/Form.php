<?php

class Modules_Dotnetcore_Settings_Form extends pm_Form_Simple
{
    public function __construct() {
        parent::__construct();
        
        // application entry point
        $this->addElement('text', 'entrypoint', [
            'label'    => pm_Locale::lmsg('formSettingsEntryPointInputLabel'),
            'required' => true,
            'value'    => null
        ]);

        // application environment
        $this->addElement('text', 'environment', [
            'label'    => pm_Locale::lmsg('formSettingsEnvironmentInputLabel'),
            'required' => true,
            'value'    => null
        ]);

        // system service name
        $this->addElement('text', 'servicename', [
            'label'    => pm_Locale::lmsg('formSettingsServiceNameInputLabel'),
            'required' => true,
            'value'    => null
        ]);

        $this->addControlButtons([
            'cancelHidden' => true,
            'sendTitle'    => pm_Locale::lmsg('formSettingsSaveButtonTitle')
        ]);
    }
}