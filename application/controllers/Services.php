<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$user_id = null;

		if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){

			$user_id = trim($_SESSION['user_id']);

		}

        $this->load->model('twitter_model');

		$bots = $this->twitter_model->get_created_bots($user_id);

		$api = $this->twitter_model->get_api_by_user_id($user_id);

		$config  = $this->build_api_info($api);

		$this->load->library('twitterlib', $config);

		foreach ($bots as $k => $bot){

			$this->twitterlib->tweets($bot->action, $bot);

		}

	}

	public function build_api_info($api){

		$config = array(
			'consumer_key' => $api->consumer_key,
			'consumer_secret' => $api->consumer_secret,
			'access_token' => $api->access_token,
			'access_secret' => $api->access_secret,
		);

		return $config;
	}
}