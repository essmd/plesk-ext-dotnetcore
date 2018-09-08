<?php

class Modules_Dotnetcore_Settings_Form extends pm_Form_Simple
{
    const ELEMENT_ENVIRONMENT = 'environment';
    const ELEMENT_ENTRY_POINT = 'entrypoint';

    public function __construct() {
        parent::__construct();
        
        // application entry point
        $this->addElement('text', self::ELEMENT_ENTRY_POINT, [
            'label'    => pm_Locale::lmsg('formSettingsEntryPointInputLabel'),
            'required' => true,
            'value'    => null
        ]);

        // application environment
        $this->addElement('text', self::ELEMENT_ENVIRONMENT, [
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


    /**
     * Validate the form
     *
     * @param  array $data
     * @return boolean
     */
    public function isValid($data) {
        $result = parent::isValid($data);

        // Entry Point
        $entryPointElement = $this->getElement(self::ELEMENT_ENTRY_POINT);
        $entryPointElementValue = $entryPointElement->getValue();

        if ($entryPointElementValue && !preg_match('/^([a-z0-9.-]+)\.dll$/i', $entryPointElementValue)) {
            $entryPointElement->addError('Invalid entry point. Only a-Z, 0-9, - and . are allowed. Name must end with .dll');
            $result = false;
            
            $this->markAsError();
        }

        // Environment
        $environmentElement = $this->getElement(self::ELEMENT_ENVIRONMENT);
        $environmentElementValue = $environmentElement->getValue();
        $environmentSupportedValues = [ 'production', 'staging', 'development' ];

        if ($environmentElementValue && !in_array($environmentElementValue, $environmentSupportedValues)) {
            $environmentElement->addError('Unsupported environment. Supported values are: ' . implode(', ', $environmentSupportedValues));
            $result = false;
            
            $this->markAsError();
        }
        
        return $result;
    }
}