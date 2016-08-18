<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('twitter_model');
		$this->load->model('user_model');

	}

	public function index()
	{
		//Get all user information
		$users = $this->twitter_model->all_users();

		foreach ($users as $u => $user) {

			unset($userinfo);

			$userinfo = $this->user_model->get_user_by_id($user->uid);

			$timezone = $userinfo->description;

			date_default_timezone_set($timezone);

			//Get all_tweets table info where status=0
			$action = $this->twitter_model->action($user->uid, $user->cid);

			date_default_timezone_set('America/Los_Angeles');

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
					case 'DM Followers':
						$content = $this->twitterlib->get_dm_followers(array('screen_name' => $api_user->screen_name));
						foreach ($content->users as $k => $a) {
							$this->twitterlib->direct_message(array('user_id' => $content->users[$k]->id, 'text' => $id->message));
						}
						break;
					case 'Follow User':
						$post_value = array('screen_name' => $id->tag);
						$this->twitterlib->follow_user($post_value);
						break;
					case 'Reply':
						$post_value = array('status' => $id->message);
						$this->twitterlib->reply($post_value);
						break;
					case 'DM':
						$post_value = array('text' => $id->message, 'screen_name' => $id->tag);
						$this->twitterlib->direct_message($post_value);
						break;
				}

				$this->twitter_model->update_bot_status($id->post_id);
				$this->twitter_model->set_individual_tweet_status($id->id);
			}
		}

		exit;
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