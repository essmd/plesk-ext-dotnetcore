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

        $domainId = $this->getRequest()->getParam('site_id');
        $this->domain = pm_Domain::getByDomainId($domainId);
    }

    /**
     * indexAction
     */
    public function indexAction() {

        // DEBUG: Test Service File Content Generation
        $service = Modules_Dotnetcore_Settings_Storage::restore($this->domain);
        $serviceFileName = Modules_Dotnetcore_Services_File::createServiceFileName($this->domain);
        $serviceFileContent = Modules_Dotnetcore_Services_File::createServiceFileContent($service);
        
        $this->view->serviceFileName = $serviceFileName;
        $this->view->serviceFileContent = $serviceFileContent;

        // create settings form and handle POST request
        $form = new Modules_Dotnetcore_Settings_Form($service);
        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {

            // persist service configuration
            $serviceOptions = $form->getValues();
            $serviceOptions['user'] = $this->domain->getSysUserLogin();
            $serviceOptions['workingDirectory'] = $this->domain->getDocumentRoot();

            $service = new Modules_Dotnetcore_Settings_Service($serviceOptions);
            Modules_Dotnetcore_Settings_Storage::persist($this->domain, $service);

            // persist service file
            if ($service->isValid()) {
                Modules_Dotnetcore_Services_File::create($this->domain, $service);
                Modules_Dotnetcore_Services_File::register($this->domain);
            }
            
            $this->_status->addInfo('Successfully saved');
            $this->_helper->json([
                'redirect' => pm_Context::getBaseUrl()
            ]);
        }

        $this->view->form = $form;
        $this->view->tools = $this->_getTools();
        $this->view->tabs = Modules_Dotnetcore_Common_TabsHelper::getDomainTabs();
        $this->view->pageTitle = pm_Locale::lmsg('pageDomainTitle', [
            'domain' => $this->domain->getName()
        ]);
    }

    public function restartAction() {

        // TODO: implement
        $this->_status->addInfo('Service restarted successfully');
        $this->_helper->redirector('index');
    }

    private function _getTools() {
        return [
            [
                'title' => 'Restart',
                'description' => 'Restart the service',
                'class' => 'sb-refresh',
                'action' => 'restart'
            ]
        ];
    }
}
