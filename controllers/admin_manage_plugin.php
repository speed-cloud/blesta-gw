<?php
/**
 * Microsoft Entra ID plugin controller
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class AdminManagePlugin extends AppController
{
    /**
     * Perfoms necessary initialization
     */
    private function init()
    {
        // Require login
        $this->parent->requireLogin();

        Language::loadLang('google_workspace_manage_plugin', null, PLUGINDIR . 'google_workspace' . DS . 'language' . DS);

        $this->plugin_id = $this->get[0] ?? null;

        // Set the page title
        $this->parent->structure->set('page_title', Language::_('GoogleWorkspace.name', true));
    }

    /**
     * Returns the view to be rendered when managing this plugin
     */
    public function index()
    {
        $this->init();

        if (!isset($this->Companies)) {
            Loader::loadComponents($this, ['Companies']);
        }

        // Get settings
        $client_id = $this->Companies->getSetting(Configure::get('Blesta.company_id'), 'GoogleWorkspace.client_id');
        $client_secret = $this->Companies->getSetting(Configure::get('Blesta.company_id'), 'GoogleWorkspace.client_secret');
        $replace_admin_login_page = $this->Companies->getSetting(Configure::get('Blesta.company_id'), 'GoogleWorkspace.replace_admin_login_page');

        $vars = [
            'plugin_id' => $this->plugin_id,
            'client_id' => $client_id->value ?? '',
            'client_secret' => $client_secret->value ?? '',
            'replace_admin_login_page' => $replace_admin_login_page->value ?? 'off',
        ];

        if (!empty($this->post)) {
            if (!isset($this->post['client_id'])) {
                $this->post['client_id'] = '';
            }

            if (!isset($this->post['client_secret'])) {
                $this->post['client_secret'] = '';
            }
            
            if (!isset($this->post['replace_admin_login_page'])) {
                $this->post['replace_admin_login_page'] = 'off';
            }
            
            $this->Companies->setSetting(
                Configure::get('Blesta.company_id'),
                'GoogleWorkspace.client_id',
                $this->post['client_id']
            );

            $this->Companies->setSetting(
                Configure::get('Blesta.company_id'),
                'GoogleWorkspace.client_secret',
                $this->post['client_secret']
            );

            $this->Companies->setSetting(
                Configure::get('Blesta.company_id'),
                'GoogleWorkspace.replace_admin_login_page',
                $this->post['replace_admin_login_page']
            );

            $this->parent->flashMessage('message', Language::_('GoogleWorkspaceManagePlugin.!success.settings_updated', true));
            $this->redirect($this->base_uri . 'settings/company/plugins/manage/' . $this->plugin_id);
        }

        // Set the view to render for all actions under this controller
        $this->view->setView(null, 'GoogleWorkspace.default');

        return $this->partial('admin_manage_plugin', $vars);
    }
}
