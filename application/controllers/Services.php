<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('twitter_model');
	}

	public function index()
	{

		//Get all user information
		$users = $this->twitter_model->all_users();

		foreach ($users as $u => $user) {

			$action = $this->twitter_model->action($user->uid, $user->cid);

			foreach ($action as $k => $id) {

				$api = $this->twitter_model->get_api_by_user_id_and_cid($user->uid, $user->cid);

				$config = $this->build_api_info($api);

				$this->load->library('twitterlib');

				$this->twitterlib = new Twitterlib($config);

				$api_user = $this->twitterlib->check();

				$switch = $id->action;

				switch ($switch) {
					case 'Favorite':
						$this->twitterlib->favorite(array('id' => $id->tweet_id));
						break;

					case 'Retweet':
						$this->twitterlib->retweet(array(array('id' => $id->tweet_id)));
						break;

					case 'RT with Comment':
						$this->twitterlib->reply(array('status' => $id->message . ' ' . 'https://twitter.com/' . $api_user->screen_name . '/status/' . $id->tweet_id));
						break;
				}

				$this->twitter_model->set_individual_tweet_status($id->id);

			}
		}
	}

	public function build_api_info($api)
	{

		$config = array(
			'consumer_key' => $api->consumer_key,
			'consumer_secret' => $api->consumer_secret,
			'access_token' => $api->access_token,
			'access_secret' => $api->access_secret,
		);

		return $config;
	}
}