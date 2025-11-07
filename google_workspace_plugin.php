<?php

use Blesta\Core\Util\Common\Traits\Container;

/**
 * Google Workspace plugin handler
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class GoogleWorkspacePlugin extends Plugin
{
    public function __construct()
    {
        $this->loadConfig(dirname(__FILE__) . DS . 'config.json');
        Language::loadLang('google_workspace', null, dirname(__FILE__) . DS . 'language' . DS);
    }

    /**
     * Listen to events.
     * @return array
     */
    public function getEvents()
    {
        return [
            [
                'event' => 'Appcontroller.structure',
                'callback' => ['this', 'on_admin_login'],
            ]
        ];
    }

    /**
     * Handles when an admin tries to access the admin page.
     *
     * @param array $event
     * @return array
     */
    public function on_admin_login($event)
    {
        Loader::loadComponents($this, ['Companies', 'Session']);
        
        $params = $event->getParams();
        $replace_admin_login_page = $this->Companies->getSetting(Configure::get('Blesta.company_id'), 'GoogleWorkspace.replace_admin_login_page');
        
        if ($params['controller'] !== 'admin_login'
            || ($replace_admin_login_page->value ?? 'off') !== 'on'
            || ($this->Session->read('blesta_id') > 0
                && $this->Session->read('blesta_staff_id') > 0)) {
            return;
        }

        return header('Location: ' . WEBDIR . 'plugin/google_workspace/login');
    }
}
