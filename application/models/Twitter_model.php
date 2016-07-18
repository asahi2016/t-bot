<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter_model extends CI_Model
{

    var $accounts_table = 'accounts';
    var $credentials_table = 'credentials';
    var $posts_table = 'posts';

    // get the active twitter account from the database, by row active = 1
    public function getActiveAccount()
    {
        return $this->db->get_where($this->accounts_table, array('active' => '1'))->row();
    }

    // update twitter status and last message on success
    public function update_status($username, $password, $message)
    {

        $this->load->library('twitterlib');

        // Post Update
        $content = $this->twitterlib->tweetpost($message);

        // if we were successfull we need to update our last_message
        if ($content) {
            $content = serialize($content);

            $this->db->where('active', '1');
            $this->db->update($this->accounts_table, array('last_message' => $message , 'response' => $content, 'updated' => date('Y:m:d H:i:s')));

            return TRUE;
        } else {
            return FALSE;
        }
    }

    // get the last_message, by row active = 1
    public function getLastMessage()
    {
        $this->db->select('last_message');
        $last_message = $this->db->get_where($this->accounts_table, array('active' => '1'))->row()->last_message;

        return htmlspecialchars($last_message);
    }


    public function get_api_by_user_id($user_id){

       if($user_id){

           $user_info = array(
               'uid' => $user_id,
           );

           return $this->db->get_where($this->credentials_table , $user_info)->row();

       }

       return false;

    }

    public function check_api_by_user_id($user_id, $api = array()){

        if(!empty($user_id)){

            $api_info = array(
                'uid' => $user_id,
                'consumer_key' => $api['consumer_key'],
                'consumer_secret' => $api['consumer_secret'],
                'access_token' => $api['access_token'],
                'access_secret' => $api['access_secret'],
            );

            return $this->db->get_where($this->credentials_table , $api_info)->row();
        }

        return false;

    }

    public function save_api_by_user_id($user_id , $api = array()){

        if(!empty($user_id)){

            $api_info = array(
                'uid' => $user_id,
                'consumer_key' => $api['consumer_key'],
                'consumer_secret' => $api['consumer_secret'],
                'access_token' => $api['access_token'],
                'access_secret' => $api['access_secret'],
                'status' => 1,
                'updated' => date('Y-m-d H:i:s'),
            );

            $this->db->insert($this->credentials_table, $api_info);

            return $this->db->insert_id();
        }


        return false;

    }

    public function save_bots($user_id, $cid, $bots = array()){

        if(!empty($user_id)){

            //Check already this api credentials has been twitter bots records
            $post = $this->check_bots($user_id, $cid);

            $api_info = array(
                /*'uid' => $user_id,
                'cid' => $cid,*/
                'message' => $bots['message'],
                'tag' => $bots['search_phrase'],
                'action' => $bots['tweet_action'],
                'start_time' => $bots['start_time'],
                'end_time' => $bots['end_time'],
                'status' => 1,
                'updated' => date('Y-m-d H:i:s'),
            );

            if(!$post) {

                $api_info['uid'] = $user_id;
                $api_info['cid'] = $cid;

                $this->db->insert($this->posts_table, $api_info);

                return $this->db->insert_id();

            }else{

                $this->db->where('uid', $user_id);
                $this->db->where('cid', $cid);
                if($this->db->update($this->posts_table , $api_info)){
                    return true;
                }
            }
        }
        return false;

    }


    public function check_bots($user_id, $cid){

        if(!empty($user_id)){

            $info = array(
                'uid' => $user_id,
                'cid' => $cid,
            );

            return $this->db->get_where($this->posts_table , $info)->row();

        }
        return false;
    }

    public function post_tweet($message, $config){

        $this->load->library('twitterlib', $config);

        // Post Update
        $content = $this->twitterlib->post($message);

        return true;
    }
}