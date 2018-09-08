<?php

class Modules_Dotnetcore_Logs_List extends pm_View_List_Simple
{
    public function __construct(Zend_View $view, Zend_Controller_Request_Abstract $request, array $logs) {
        parent::__construct($view, $request, [
            'pageable'             => false,
            'defaultItemsPerPage'  => 50,
            'defaultSortField'     => 'column-1',
            'defaultSortDirection' => pm_View_List_Simple::SORT_DIR_UP,
            'searchable'           => false
        ]);

        $this->_setData($view, $logs);
        $this->_setColumns();
        $this->_setTools();
        
        $this->setDataUrl([ 'action' => 'list-data' ]);
    }

    private function _setData($view, $logs) {
        $data = [];

        foreach ($logs as $log) {
            $data[] = [
                'column-1' => self::getHumandReadableDateTimeText($log->timestamp),
                'column-2' => self::getHumandReadableEventTypeText($log->type),
                'column-3' => $log->message
            ];
        }

        $this->setData($data);
    }

    private function _setColumns() {
        $this->setColumns([
            'column-1' => [
                'title'      => pm_Locale::lmsg('pageLogsListColumnTimestamp'),
                'sortable'   => true,
                'searchable' => false,
                'noEscape'   => true
            ],
            'column-2' => [
                'title'      => pm_Locale::lmsg('pageLogsListColumnType'),
                'sortable'   => false,
                'searchable' => false,
                'noEscape'   => true
            ],
            'column-3' => [
                'title'      => pm_Locale::lmsg('pageLogsListColumnMessage'),
                'sortable'   => false,
                'searchable' => false
            ]
        ]);
    }

    private function _setTools() {
        $this->setTools([
            [
                // 'icon' => pm_Context::getBaseUrl() . '/images/ui-icons/gear_32.png',
                'title' => pm_Locale::lmsg('pageLogsToolbarRefresh'),
                'description' => pm_Locale::lmsg('pageLogsToolbarRefreshDescription'),
                'class' => 'sb-refresh',
                'action' => 'index'
            ],
        ]);
    }

    /**
     * @param $type
     *
     * @return string
     */
    private static function getHumandReadableEventTypeText($type) {
        return strtoupper($type);
    }

    /**
     * @param $dateTime
     *
     * @return false|string
     */
    private static function getHumandReadableDateTimeText($dateTime) {
        return date('Y-m-d H:i:s', $dateTime);
    }
}