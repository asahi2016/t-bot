<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter_model extends CI_Model
{

    var $accounts_table = 'accounts';
    var $credentials_table = 'credentials';
    var $posts_table = 'posts';
    var $relation_table = 'relations';
    var $all_tweets = 'all_tweets';

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

    public function get_api_by_user_id_and_cid($user_id , $cid){

        if($user_id){

            $user_info = array(
                'cid' => $cid,
                'uid' => $user_id,
            );

            return $this->db->get_where($this->credentials_table , $user_info)->row();

        }

        return false;

    }

    public function all_users(){
        /*$this->db->select('*');
        $this->db->from("$this->posts_table post");
        $this->db->join("$this->credentials_table credential", "credential.uid = post.uid AND credential.cid = post.cid", "left");*/
        return $this->db->get($this->credentials_table)->result();
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

    public function save_bots($user_id, $cid, $bots = array(), $total = array()){

        if(!empty($user_id)){


            $bot_relation = array(
                'uid' => $user_id,
                'cid' => $cid,
                'data' => serialize($bots),
                'updated' => date('Y-m-d H:i:s'),
            );

            $relation_id = '';

            if($this->db->insert($this->relation_table, $bot_relation)){
                $relation_id = $this->db->insert_id();
            }

            if($relation_id) {
                //Check already this api credentials has been twitter bots records
                foreach ($total as $k => $val) {

                    if ($k <= $bots['totalbots']) {

                        $api_info = array(
                            'uid' => $user_id,
                            'cid' => $cid,
                            'message' => $bots['message'][$k],
                            'tag' => $bots['search_phrase'][$k],
                            'action' => $bots['tweet_action'][$k],
                            'start_time' => $bots['start_time'][$k],
                            'end_time' => $bots['end_time'][$k],
                            'relation' => $relation_id,
                            'status' => 0,
                            'updated' => date('Y-m-d H:i:s'),
                        );

                        $this->db->insert($this->posts_table, $api_info);
                    }

                }

                return true;
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

    public function get_created_bots($user_id = null){

            $this->db->select('post.*');
            $this->db->from("$this->relation_table rel");
            $this->db->join("$this->posts_table post", "rel.relation_id = post.relation", "left");

            if(!empty($user_id)){
                $this->db->where("rel.uid", $user_id);
            }

            $this->db->where("post.status", 0);
            $query = $this->db->get();

            return $query->result();

    }

    public function update_bot_status($post_id)
    {
        $data=array('status'=>1);
        $this->db->where('post_id',$post_id);
        $this->db->update($this->posts_table,$data);
    }

    public function update_post_status($id){
        $data=array('status'=>1);
        $this->db->where('post_id',$id);
        $this->db->update($this->all_tweets,$data);

    }

    //set_individual_tweet_status
    public function set_individual_tweet_status($id){
        //$data=array('status'=>1);
        $this->db->where('id',$id);
        $this->db->delete($this->all_tweets);
    }


    public function check_tweets_by_single_bot($bot){

        $data = array(
            'post_id' => $bot->post_id,
            'uid' => $bot->uid,
            'cid' => $bot->cid,
            'status' => 0
        );

        return $this->db->get_where($this->all_tweets , $data)->row();
    }

    public function save_all_tweets_info($bot, $tweet_id)
    {
        $data = array(
            'post_id' => $bot->post_id,
            'cid' => $bot->cid,
            'uid' => $bot->uid,
            'action' => $bot->action,
            'tweet_id' => $tweet_id,
            'status' => 0,
            'comment' =>$bot->message,
            'created' => date('Y-m-d H:i:s'),
            'updated' =>date("Y-m-d H:i:s"),
        );

        if ($this->db->insert($this->all_tweets, $data)) {
            return $this->db->insert_id();

        }

        return false;
    }
    public function pot_status($user_id)
    {
        $hour = date("H");
        $this->db->select('*');
        $this->db->from("$this->posts_table");

        $this->db->where("status", 0);
        $this->db->where("end_time>=$hour");
        $this->db->where("start_time<=$hour");
        $query = $this->db->get();
        return $query->result();
    }


    public function action($user_id = null, $cid = null)
    {
        $hour = date("H");
        $this->db->select('*');
        $this->db->from("$this->posts_table post");
        $this->db->join("$this->all_tweets tweet", "tweet.uid = post.uid AND tweet.cid = post.cid AND post.post_id = tweet.post_id AND post.start_time <= $hour AND post.end_time>=$hour", "left");

        if (!empty($user_id)) {
            $this->db->where("tweet.uid", $user_id);
        }
        if (!empty($cid)){
            $this->db->where("tweet.cid", $cid);
        }
        $this->db->where("tweet.status", 0);
        $this->db->group_by('post.post_id');
        $this->db->order_by("tweet.id",'ASC');
        $query = $this->db->get();

        return $query->result();

    }

}
