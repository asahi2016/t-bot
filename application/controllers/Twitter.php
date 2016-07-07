<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('twitter_model');

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

    public function index()
    {
        $data['heading'] = 'Hi, send a tweet!';
        $data['last_message'] = $this->twitter_model->getLastMessage();
        $data['active_user'] = $this->twitter_model->getActiveAccount()->username;

        //print_pre($_SESSION['user'],1);
        $data['user'] = $_SESSION['user'];

        $this->load->view('header', $data);
        $this->load->view('index', $data);
        $this->load->view('footer');
    }

    // updating our status on twitter ( new message )
    public function update()
    {

        if ($this->input->post('botsubmit')) {

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[5]|max_length[140]');

            if ($this->form_validation->run() == FALSE) {
                $this->index();
            } else {

                $message = $this->input->post('message');

                // get useraccount data
                $account = $this->twitter_model->getActiveAccount();
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
}