<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web extends CI_Controller {

	public function __construct()
	{
		// Constructor to auto-load HybridAuthLib
		parent::__construct();
		$this->load->library('HybridAuthLib');
		$this->load->model('User_model');
	}

	public function index()
	{
		// Send to the view all permitted services as a user profile if authenticated
		$login_data['providers'] = $this->hybridauthlib->getProviders();
		foreach($login_data['providers'] as $provider=>$d) {
			if ($d['connected'] == 1) {
				$login_data['providers'][$provider]['user_profile'] = $this->hybridauthlib->authenticate($provider)->getUserProfile();
			}
		}

		$this->load->view('header', $login_data);
		$this->load->view('login/home', $login_data);
		$this->load->view('footer', $login_data);
	}

	public function login($provider)
	{
		log_message('debug', "controllers.Web.login($provider) called");

		try
		{
			log_message('debug', 'controllers.Web.login: loading HybridAuthLib');
			$this->load->library('HybridAuthLib');

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				log_message('debug', "controllers.Web.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected())
				{
					log_message('debug', 'controller.Web.login: user authenticated.');

					$user_profile = $service->getUserProfile();

					log_message('info', 'controllers.Web.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));


					if(!empty($user_profile->identifier) && !$user = $this->User_model->get_user_by_social_identifier($user_profile->identifier)) {

						$user = $this->User_model->prepare_user_info_array($user_profile, $provider, 'social');

						if ($user) {

							$user_id = $this->User_model->insert_user($user);

							if($user_id){

								$_SESSION['user_id'] = $user_id;
								$_SESSION['user']  = $this->User_model->get_user_by_id($user_id);

							}else{
								log_message('info', 'controllers.Web.login: user profile does not inserted properly.');
								$login_data['login_error'] = 'Sorry! some technical issues occured, We will resolve shortly.';
							}
						}
					}else{

						$_SESSION['user_id'] = $user->uid;
						$_SESSION['user']  = $this->User_model->get_user_by_id($user->uid);

					}

					redirect('twitter');

				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				log_message('error', 'controllers.Web.login: This provider is not enabled ('.$provider.')');
				show_404($_SERVER['REQUEST_URI']);
			}
		}
		catch(Exception $e)
		{
			$error = 'Unexpected error';
			switch($e->getCode())
			{
				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : log_message('debug', 'controllers.Web.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	log_message('debug', 'controllers.Web.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
			}

			if (isset($service))
			{
				$service->logout();
			}

			log_message('error', 'controllers.Web.login: '.$error);
			show_error('Error authenticating user. '.base_url());
		}
	}

	public function endpoint()
	{

		log_message('debug', 'controllers.Web.endpoint called.');
		log_message('info', 'controllers.Web.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			log_message('debug', 'controllers.Web.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		log_message('debug', 'controllers.Web.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}


	public function logout($provider)
	{

		session_destroy();

		header('Location: https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.base_url().'');

		//redirect(base_url());

	}
}

/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
