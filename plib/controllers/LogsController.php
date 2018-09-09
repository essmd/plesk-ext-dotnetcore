<?php

class LogsController extends pm_Controller_Action
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
     *
     * Main action of the controller. Forwards to listAction
     */
    public function indexAction() {
        $this->_forward('list');
    }

    /**
     * listAction
     *
     * Action used to provide a list of service log entries
     */
    public function listAction() {
        $logs = $this->_getLogsForDomain($this->domain);
        $logsList = new Modules_Dotnetcore_Logs_List($this->view, $this->_request, $logs);

        $this->view->list = $logsList;
        $this->view->tabs = Modules_Dotnetcore_Common_TabsHelper::getDomainTabs($this->domain, 'logs');
        $this->view->pageTitle = pm_Locale::lmsg('pageLogsTitle', [
            'domain' => $this->domain->getName()
        ]);
    }
        
    /**
     * listDataAction
     *
     * Action to retrieve only the list data
     *
     * @return array
     */
    public function listDataAction() {
        $logs = $this->_getLogsForDomain($this->domain);
        $logsList = new Modules_Dotnetcore_Logs_List($this->view, $this->_request, $logs);

        $this->_helper->json($logsList->fetchData());
    }

    /**
     * Get logs for the given domain service
     * 
     * @return array
     */
    private function _getLogsForDomain(pm_Domain $domain) {
        $serviceFileName = Modules_Dotnetcore_Services_File::createServiceFileName($domain);
        $serviceLogs = Modules_Dotnetcore_Logs_Helper::getLogEntriesForService($serviceFileName);

        return $serviceLogs;
    }
}