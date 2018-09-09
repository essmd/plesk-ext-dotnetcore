<?php

class Modules_Dotnetcore_Settings_Storage
{
    const PREFIX_SEPARATOR      = '_';
    const PREFIX_MODULE_NAME    = 'dotnetcore';

    /**
     * Persist the given service for the given domain
     */
    public static function persist(pm_Domain $domain, Modules_Dotnetcore_Settings_Service $service) {
        $prefix = self::_createSettingsPrefixForDomain($domain, 'service');

        pm_Settings::set($prefix . 'name', $service->getName());
        pm_Settings::set($prefix . 'user', $service->getUser());
        pm_Settings::set($prefix . 'entryPoint', $service->getEntryPoint());
        pm_Settings::set($prefix . 'environment', $service->getEnvironment());
        pm_Settings::set($prefix . 'workingDirectory', $service->getWorkingDirectory());
    }

    /**
     * Try to restore the settings for the given domain
     * 
     * @param pm_Domain $domain The Domain to restore for
     * 
     * @return Modules_Dotnetcore_Settings_Service|null
     */
    public static function restore(pm_Domain $domain) {
        $prefix = self::_createSettingsPrefixForDomain($domain, 'service');
        $options = [ 
            'name' => null,
            'user' => null,
            'entryPoint' => null,
            'environment' => null,
            'workingDirectory' => null 
        ];

        foreach ($options as $key => $value) {
            $options[$key] = pm_Settings::get($prefix . $key);
        }

        return new Modules_Dotnetcore_Settings_Service($options);
    }

    /**
     * Destroy settings for the given domain
     */
    public static function destroy(pm_Domain $domain) {
        $prefix = self::_createSettingsPrefixForDomain($domain);
        pm_Settings::clean($prefix);
    }

    /**
     * Create the prefix for the given domain
     */
    private static function _createSettingsPrefixForDomain(pm_Domain $domain, $type = null) {
        $prefix = self::PREFIX_MODULE_NAME 
                . self::PREFIX_SEPARATOR 
                . $domain->getId() 
                . self::PREFIX_SEPARATOR;

        if (!empty($type)) {
            $prefix = $prefix . $type . self::PREFIX_SEPARATOR;
        }

        return $prefix;
    }
}