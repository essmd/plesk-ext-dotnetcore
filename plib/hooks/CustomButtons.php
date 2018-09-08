<?php

class Modules_DotNetCore_CustomButtons extends pm_Hook_CustomButtons
{
    public function getButtons() {
        return [
            [
                'place' => self::PLACE_DOMAIN_PROPERTIES,
                'title' => pm_Locale::lmsg('dotNetCoreDomainButtonTitle'),
                'description' => pm_Locale::lmsg('dotNetCoreDomainButtonDescription'),
                'icon' => pm_Context::getBaseUrl() . 'images/button_domain_64.png',
                'link' => pm_Context::getActionUrl('index', 'index'),
                'visibility' => [ $this, 'isDotNetCoreApplication' ],
                'contextParams' => true
            ]
        ];
    }

    public function isDotNetCoreApplication() {
        return true;
    }
}
