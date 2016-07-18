<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter extends CI_Controller
{
    public $user;

    public $postval;

    public function __construct()
    {

        parent::__construct();

        $this->user = isset($_SESSION['user_id'])? $_SESSION['user']:'';

        $this->load->model('twitter_model');
        $this->load->model('user_model');
        $this->load->library('form_validation');

        if(!$this->is_user_logged_in()){
            redirect('web');
        }

    }

    public function is_user_logged_in(){

        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
             return true;
        }

        return false;
    }

    public function index($data = array())
    {

        $data['user'] = $this->user;

        if($this->input->post('botsubmit')){

          if(validation_errors()) {
              $data = $this->get_postval();
          }else{
              $data['success'] = $this->session->userdata('success');
              $this->session->unset_userdata('success');
          }
        }

        //Get current user api credentials
        $user_api = $this->twitter_model->get_api_by_user_id($this->user->uid);

        if($user_api){
            $data = $this->build_user_api_info($user_api);
        }

        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer');
    }


    public function build_user_api_info($api){

        $config = array(
            'consumer_key' => $api->consumer_key,
            'consumer_secret' => $api->consumer_secret,
            'access_token' => $api->access_token,
            'access_secret' => $api->access_secret,
        );

        return $config;
    }


    // updating our status on twitter ( new message )
    public function update()
    {

        if ($this->input->post('botsubmit')) {

            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[5]|max_length[140]');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {

                //Check api credentials are already exists in the user account
                $api_info = $this->get_postval();
                $api_exists = $this->twitter_model->check_api_by_user_id($this->user->uid , $api_info);

                $cid = '';

                if(!$api_exists) {
                    //Store api credentials to current logged in user account
                    $cid = $this->twitter_model->save_api_by_user_id($this->user->uid, $api_info);
                }else{
                    $cid = $api_exists->cid;
                }

                //Save bot with current user id  and  api credentials id

                if($cid){

                    $this->twitter_model->save_bots($this->user->uid, $cid,  $api_info);
                }


                $message = $this->input->post('message');

                // get useraccount data
                $account = $this->user_model->get_user_by_id($this->user->uid);
                $username = $account->username;
                $password = $account->password;

                // send a tweet
                if ($this->twitter_model->update_status($username, $password, $message)) {
                    redirect('twitter');
                } else {
                    $data['error'] = 'There was an error while updating your status';

                    $this->load->view('header', $data);
                    $this->load->view('error');
                    $this->load->view('footer');
                }
            }
        } else {
            redirect('twitter');
        }
    }


    public function create(){

        if ($this->input->post('botsubmit')) {

            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            $this->form_validation->set_rules('consumer_key', 'Consumer key', 'trim|required');
            $this->form_validation->set_rules('consumer_secret', 'Consumer secret', 'trim|required');
            $this->form_validation->set_rules('access_token', 'Access token', 'trim|required');
            $this->form_validation->set_rules('access_secret', 'Access secret', 'trim|required');
            $this->form_validation->set_rules('search_phrase', 'Search phrase', 'trim|required');
            $this->form_validation->set_rules('tweet_action', 'Action', 'trim|required');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');
            $this->form_validation->set_rules('start_time', 'Start time', 'trim|required');
            $this->form_validation->set_rules('end_time', 'End time', 'trim|required');
            $this->form_validation->set_rules('authcheck', 'API Credentials status', 'callback_check_user_api_credentials');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {

                $data = array();

                //Check api credentials are already exists in the user account
                $api_info = $this->get_postval();

                $api_exists = $this->twitter_model->check_api_by_user_id($this->user->uid , $api_info);

                $cid = '';

                if(!$api_exists) {
                    //Store api credentials to current logged in user account
                    $cid = $this->twitter_model->save_api_by_user_id($this->user->uid, $api_info);
                }else{
                    $cid = $api_exists->cid;
                }

                //Save bot with current user id  and  api credentials id
                if($cid){

                    $save = $this->twitter_model->save_bots($this->user->uid, $cid,  $api_info);

                    if($save){

                       $this->session->set_userdata('success', 'Twitter bots created successfully.');
                       $data['success'] = 'Twitter bots created successfully.';
                    }
                }

                $user_api = $this->twitter_model->get_api_by_user_id($this->user->uid);

                $config = '';
                if($user_api){
                    $config = $this->build_user_api_info($user_api);
                }

                $this->twitter_model->post_tweet($this->input->post('message'), $config);

                $this->index($data);

            }
        }else{
            $this->index();
        }

    }


    public function check_user_api_credentials(){

        $config = array(
            'consumer_key' => trim($this->input->post('consumer_key')),
            'consumer_secret' => trim($this->input->post('consumer_secret')),
            'access_token' => trim($this->input->post('access_token')),
            'access_secret' => trim($this->input->post('access_secret'))
        );


        $this->load->library('twitterlib', $config);

        $conn = $this->twitterlib->check();

        if(!$conn){
            $this->form_validation->set_message('check_user_api_credentials','Sorry, we could not authendicated you. please provide valid api credentials.');
            return false;
        }

        return $conn;

    }


    public function get_postval(){

        $config = array(
            'consumer_key' => trim($this->input->post('consumer_key')),
            'consumer_secret' => trim($this->input->post('consumer_secret')),
            'access_token' => trim($this->input->post('access_token')),
            'access_secret' => trim($this->input->post('access_secret')),
            'search_phrase' => trim($this->input->post('search_phrase')),
            'tweet_action' => trim($this->input->post('tweet_action')),
            'message' => trim($this->input->post('message')),
            'start_time' => trim($this->input->post('start_time')),
            'end_time' => trim($this->input->post('end_time')),
        );

       return $this->postval = $config;

    }


}