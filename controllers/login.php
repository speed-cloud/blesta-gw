<?php
/**
 * Google Workspace plugin handler
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class Login extends AppController
{
    /**
    * Handle login requests
    */
    public function index()
    {
        // Get settings
        $client_id = $this->Companies->getSetting($this->company_id, 'GoogleWorkspace.client_id')->value ?? '';
        
        $this->redirect('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
            'client_id' => $client_id,
            'response_type' => 'code',                                                                                                                                        
            'scope' => 'openid email profile',                                                                                                                  
            'redirect_uri' => $this->base_url . 'plugin/google_workspace/callback',                                                                                                       
        ]));
    }
}
