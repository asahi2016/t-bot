<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter extends CI_Controller
{
    public $user;

    public $postval;

    public $total_bots = 5;

    public $bots = array();

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

        $this->bots = $this->get_total_bots_array($this->total_bots);

    }

    public function get_total_bots_array($total){

        $botarray = array();

        if($total) {
            for ($i = 1; $i <= $total; $i++) {
                array_push($botarray, $i);
            }
        }

        return $botarray;

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
            $api = $this->build_user_api_info($user_api);
            $data = array_merge($data,$api);
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


    // Save new bots

    public function create(){

        if ($this->input->post('botsubmit')) {

            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            $this->form_validation->set_rules('consumer_key', 'Consumer key', 'trim|required');
            $this->form_validation->set_rules('consumer_secret', 'Consumer secret', 'trim|required');
            $this->form_validation->set_rules('access_token', 'Access token', 'trim|required');
            $this->form_validation->set_rules('access_secret', 'Access secret', 'trim|required');
            $this->form_validation->set_rules('authcheck', 'API Credentials status', 'callback_check_user_api_credentials');


            foreach ($this->bots as $index => $val) {

                if($index <= $this->input->post('totalbots')) {

                    $this->form_validation->set_rules('search_phrase[' . $index . ']', 'Search phrase', 'trim|required');
                    $this->form_validation->set_rules('tweet_action[' . $index . ']', 'Action', 'trim|required');
                    $this->form_validation->set_rules('message[' . $index . ']', 'Message', 'trim|required');
                    $this->form_validation->set_rules('start_time[' . $index . ']', 'Start time', 'trim|required');
                    $this->form_validation->set_rules('end_time[' . $index . ']', 'End time', 'trim|required');

                }
            }

            if ($this->form_validation->run() == FALSE) {
                //$this->index();

                if($this->input->post('botsubmit')){

                    $data = validation_errors();

                    echo json_encode($data);
                }

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

                    $save = $this->twitter_model->save_bots($this->user->uid, $cid, $api_info, $this->bots);

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

                //$this->twitter_model->post_tweet($this->input->post('message'), $config);

                //$this->index($data);
                echo json_encode($data);

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

       $values = array();

       if($this->input->post()) {
           $values = $this->input->post();
       }

       return $values;

    }


    public function additem(){

        $total_bots = $this->input->post('bots');

        if($this->input->post('action') == 'add'){

            $data['bkey'] = $total_bots + 1;
            $data['class'] = 'class = active';
            $data['display'] = 'display : block';
            $data['bot'] = $data['bkey'] + 1;

            $content = $this->load->view('addbots', $data, true);

            echo json_encode(array('content' => $content, 'total_bots' => $data['bkey']));

        }
    }

}