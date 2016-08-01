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
        $this->load->model('user_model');

		//Get all user lists
		$bots = $this->twitter_model->get_created_bots();

		foreach ($bots as $k => $bot){

			$user_id = $bot->uid;

			$user = $this->user_model->get_user_by_id($user_id);

			$timezone = $user->description;

			$timezone = 'Asia/Kolkata';

			date_default_timezone_set($timezone);

			$hour = date("H");

			date_default_timezone_set('America/Los_Angeles');

			//if($bot->start_time >= $hour && $bot->end_time <= $hour) {

				$api = $this->twitter_model->get_api_by_user_id($user_id);

				$config = $this->build_api_info($api);

				$this->load->library('twitterlib', $config);

				if ($this->twitterlib->tweets($bot->action, $bot)) {
					//Update twitter bot status as 1
					$this->twitter_model->update_bot_status($bot->post_id);
				}
			//}

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