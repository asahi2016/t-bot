<?php

/*
 * @author : Krishnamoorthy <www.asahitechnologies.com>
 * post tweets with twitter OAuth library
 */
define('CONSUMER_KEY' , 'KsNZXPk138cRE5LOaW8I5oSln');
define('CONSUMER_SECRET' , '8AulntgwzuxkQAznMIPs4MQjxsWlEfjJandKpy4JfMdOAqSXwO');
define('TWIT_OAUTH_TOKEN' , '748075771244118016-63qGWcvCs2EDjSO6KowkzwpN2IKyq2O');
define('TWIT_OAUTH_TOKEN_SECRET' , 'NjGzsTgkpDzgZFVd3KZHmOYaVoTUgsrSaeKewfYSQ4QVR');

require __DIR__."/Abraham/TwitterOAuth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = '';

class Twitterlib{

    public $consumer_key = '';

    public $consumer_secret = '';

    public $oauth_token = '';

    public $oauth_token_secret = '';

    public $direct = 'direct_messages/new';

    public $retweet = 'statuses/retweet/';

    public $follow = 'friendships/create';

    public $search = 'search/tweets';

    public $user_search = 'users/search';

    public $reply= 'statuses/update';

    public $favorite= 'favorites/create';

    public $followers_list= 'followers/list';

    public $add= 'lists/members/create';

    public function __construct($config = array())
    {

        if(!empty($config)) {

            $this->consumer_key = isset($config['consumer_key']) ? $config['consumer_key'] : '';
            $this->consumer_secret = isset($config['consumer_secret']) ? $config['consumer_secret'] : '';
            $this->oauth_token = isset($config['access_token']) ? $config['access_token'] : '';
            $this->oauth_token_secret = isset($config['access_secret']) ? $config['access_secret'] : '';

        }

        $this->connection = new TwitterOAuth($this->consumer_key , $this->consumer_secret , $this->oauth_token , $this->oauth_token_secret);
        //$this->connection = new TwitterOAuth(CONSUMER_KEY , CONSUMER_SECRET , TWIT_OAUTH_TOKEN , TWIT_OAUTH_TOKEN_SECRET);
    }

    public function tweets($action, $bot)
    {
        $service_url = '';
        $post_value = array();
        $content='';

        $return = false;


        $api_user = $this->check();

        switch($action){

            case 'DM':
                $post_value = array('text' => $bot->message, 'screen_name' => $bot->tag);
                if($this->direct_message($post_value)){
                    $return = true;
                }
                break;

            case 'Retweet':
                $post_value = array('q' => $bot->tag, 'result_type' => 'recent');
                $tweet_info = $this->get_tweet_search_results($post_value);
                foreach ($tweet_info->statuses as $k => $tweet){
                    $retweet=$this->retweet(array(array('id' => $tweet_info->statuses[$k]->id)));
                    if($retweet){
                        $return = true;
                    }
                }
                break;

            case 'Follow User':
                $post_value = array('screen_name' => $bot->tag);
                if($this->follow_user($post_value)){
                    $return = true;
                }
                break;

            case 'RT with Comment':
                $post_value = array('q' => $bot->tag, 'result_type' => 'recent');
                $tweet_info=$this->get_tweet_search_results($post_value);
                foreach ($tweet_info->statuses as $k => $tweet){
                    $content=$this->reply(array('status'=>$bot->message.' '.'https://twitter.com/'.$api_user->screen_name.'/status/'.$tweet_info->statuses[$k]->id));
                    if($content){
                        $return = true;
                    }
                }
                break;

            case 'Reply':

                $post_value = array('status'=> $bot->message);
                if($this->reply($post_value)){
                    $return = true;
                }
                break;

            case 'Add to Twitter List':
                $post_value= array('q' => $bot->tag);
                $content = $this->get_user_search_results($post_value );
                foreach ($content as $k => $val){
                    $log = $this->add_to_twitter_lists(array('slug' => $bot->message, 'owner_screen_name' => $api_user->screen_name , 'user_id' => $content[$k]->id));
                    if($log){
                        $return = true;
                    }
                }
                break;

            case 'Favorite':

                $post_value=array('q' => $bot->tag, 'result_type' => 'recent');
                $tweet_info=$this->get_tweet_search_results($post_value);
                foreach ($tweet_info->statuses as $k => $tweet)
                {
                    $content=$this->favorite(array('id' => $tweet_info->statuses[$k]->id));
                    if($content){
                        $return = true;
                    }
                }
                break;

            case 'DM Followers':
                $content = $this->get_dm_followers(array('screen_name'=> $api_user->screen_name ));
                foreach ($content->users as $k => $a) {
                   $log = $this->direct_message(array('user_id' => $content->users[$k]->id, 'text' => $bot->message));
                   if($log){
                       $return = true;
                   }
                }
                break;
        }

        return $return;

    }

    public function get_dm_followers($post_values = array()){


        $return = false;

        $content = $this->connection->get($this->followers_list, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }

    public function get_tweet_search_results($post_values = array()){


        $return = false;

        $content = $this->connection->get($this->search, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function get_user_search_results($post_values = array()){


        $return = false;

        $content = $this->connection->get($this->user_search, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function direct_message($post_values = array()){

        $return = false;

        $content = $this->connection->post($this->direct, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function retweet($ids = array()){

        $return = false;

        foreach ($ids as $id) {

            $content = $this->connection->post($this->retweet.$id['id']);
        }

        if($content){
            $return = true;
        }

        return $return;

    }

    public function follow_user($post_values = array()){
        //$this->follow

        $return = false;

        $content = $this->connection->post($this->follow, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function reply($post_values = array()){

        $return = false;

        $content = $this->connection->post($this->reply, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function add_to_twitter_lists($post_values = array()){

        $return = false;

        $content = $this->connection->post($this->add, $post_values);

        print_pre($content,1);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function favorite($post_values = array()){

        $return = false;

        $content = $this->connection->post($this->favorite, $post_values);

        if($content){
            $return = $content;
        }

        return $return;

    }


    public function check(){

        $credentials = $this->connection->get('account/verify_credentials');

        if(isset($credentials->id) && !empty($credentials->id)){

            return $credentials;

        }

        return false;

    }

    public function post($url, $post){

        $result = $this->connection->post($url , $post);

        if (isset($result->id) && !empty($result->id) && is_numeric($result->id)) {
            return $result;
        }

        return false;

    }

    public function get($url, $post){

        $result = $this->connection->get($url , $post);

        if (isset($result->id) && !empty($result->id) && is_numeric($result->id)) {
            return $result;
        }

        return false;

    }

}