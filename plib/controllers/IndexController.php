<?php

class IndexController extends pm_Controller_Action
{
    /**
     * @var null|pm_Domain Current Domain of the user
     */
    private $domain = null;

    /**
     * init
     *
     * Override to initialize the current user domain once and for all
     */
    public function init() {
        parent::init();
        $this->domain = pm_Session::getCurrentDomain();
    }

    /**
     * indexAction
     */
    public function indexAction() {
        $paths = [
            'home'    => $this->domain->getHomePath(),
            'docroot' => $this->domain->getDocumentRoot(),
            'vhost'   => $this->domain->getVhostSystemPath()
        ];

        $service = new Modules_Dotnetcore_Settings_Service([
            'name' => 'app-name-from-settings',
            'entryPoint' => 'EntryPointFromSettings.dll',
            'environment' => 'production',
            'workingDirectory' => $this->domain->getDocumentRoot()
        ]);

        $serviceUser = $this->domain->getSysUserLogin();
        $serviceFileContent = $service->generateServiceFileContent($serviceUser);

        $settingsForm = new Modules_Dotnetcore_Settings_Form();

        $this->view->paths = $paths;
        $this->view->serviceFileContent = $serviceFileContent;

        $this->view->form = $settingsForm;
        $this->view->tabs = Modules_Dotnetcore_Common_TabsHelper::getDomainTabs();
        $this->view->pageTitle = pm_Locale::lmsg('pageDomainTitle', [
            'domain' => $this->domain->getName()
        ]);
    }
}
