<?php
/**
 * Google Workspace plugin handler
 *
 * @copyright Copyright (c) 2025, SPEED CLOUD
 * @license GPL
 * @link https://speed-cloud.fr SPEED CLOUD
 */
class Callback extends AppController
{
    /**
    * Handle callback requests
    */
    public function index()
    {
        $this->uses(['Record', 'Session']);
        
        $client_id = $this->Companies->getSetting($this->company_id, 'GoogleWorkspace.client_id')->value ?? '';
        $client_secret = $this->Companies->getSetting($this->company_id, 'GoogleWorkspace.client_secret')->value ?? '';

        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'grant_type' => 'authorization_code',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $this->get['code'],
                'redirect_uri' => $this->base_url . 'plugin/google_workspace/callback'
            ]),
        ]);
        
        $token = json_decode(curl_exec($ch))->access_token;
        curl_close($ch);

        if (!$token) {
            return $this->redirect($this->base_uri . 'plugin/google_workspace/login');
        }
        
        $ch = curl_init('https://www.googleapis.com/oauth2/v1/userinfo');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token]
        ]);

        $email = json_decode(curl_exec($ch))->email;
        curl_close($ch);

        $staff = $this->Record->select()
			->from('staff')
			->where('email', '=', $email)
			->fetch();
        
        if (!$staff) {
            return $this->redirect($this->base_uri);
        }
        
        $this->Session->write('blesta_id', $staff->user_id);
        $this->Session->write('blesta_company_id', 0);
        $this->Session->write('blesta_staff_id', $staff->id);
        $this->redirect($this->admin_uri);
    }
}
