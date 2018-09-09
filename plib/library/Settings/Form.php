<?php

class Modules_Dotnetcore_Settings_Form extends pm_Form_Simple
{
    const ELEMENT_SERVICE_NAME  = 'name';
    const ELEMENT_ENVIRONMENT   = 'environment';
    const ELEMENT_ENTRY_POINT   = 'entryPoint';

    public function __construct(Modules_Dotnetcore_Settings_Service $service = null) {
        parent::__construct();

        // application entry point
        $this->addElement('text', self::ELEMENT_ENTRY_POINT, [
            'label'    => pm_Locale::lmsg('formSettingsEntryPointInputLabel'),
            'required' => true,
            'value'    => $service ? $service->getEntryPoint() : null
        ]);

        // application environment
        $this->addElement('text', self::ELEMENT_ENVIRONMENT, [
            'label'    => pm_Locale::lmsg('formSettingsEnvironmentInputLabel'),
            'required' => true,
            'value'    => $service ? $service->getEnvironment() : null
        ]);

        // system service name
        $this->addElement('text', self::ELEMENT_SERVICE_NAME, [
            'label'    => pm_Locale::lmsg('formSettingsServiceNameInputLabel'),
            'required' => true,
            'value'    => $service ? $service->getName() : null
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

        // Service Name
        $serviceNameElement = $this->getElement(self::ELEMENT_SERVICE_NAME);
        $serviceNameElementValue = $serviceNameElement->getValue();

        if ($serviceNameElementValue && !preg_match('/^([a-z0-9-]+)$/i', $serviceNameElementValue)) {
            $entryPointElement->addError('Invalid service name. Only a-Z, 0-9 and - are allowed');
            $result = false;
            
            $this->markAsError();
        }
        
        return $result;
    }
}