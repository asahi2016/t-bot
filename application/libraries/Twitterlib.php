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

    public $reply= 'statuses/update';

    public $favorite= 'favorites/create';

    public $follow_list= 'followers/list';

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

        $api_user = $this->check();

        switch($action){

            case 'DM':
                $service_url = $this->direct;
                $post_value = array('text' => $bot->message, 'screen_name' => $bot->tag);
                $this->connection->post($service_url, $post_value);
                break;

            case 'Retweet':
                $service_url = $this->search;
                $post_value = array('q' => $bot->tag, 'result_type' => 'recent');
                $tweet_info=$this->connection->get($service_url,$post_value);
                foreach ($tweet_info as $k => $tweet){
                    $content=$this->connection->post($this->retweet.$tweet[0]->id);
                }
                break;

            case 'Follow User':
                $service_url = $this->follow;
                $post_value = array('screen_name' => $bot->tag);
                $this->post($service_url, $post_value);
                break;

            case 'RT with Comment':

                $service_url = $this->search;
                $post_value = array('q' => $bot->tag, 'result_type' => 'recent');
                $tweet_info=$this->connection->get($service_url,$post_value);
                foreach ($tweet_info as $k => $tweet){
                    $content=$this->connection->post('statuses/update',array('status'=>$bot->message.' '.'https://twitter.com/'.$api_user->screen_name.'/status/'.$tweet[0]->id));
                }
                break;


            case 'Reply':
                $service_url = $this->reply;
                $post_value = array('status'=> $bot->message);
                $content=$this->connection->post($service_url,$post_value);
                break;

            case 'Add to Twitter List':
                $service_url = $this->search;
                $post_value= array('q' => $bot->tag);
                $content = $this->connection->get('users/search',$post_value );
                for ($i = 0; $i < 10; $i++) {
                    $log = $this->connection->post('lists/members/create', array('slug' => 'family', 'owner_screen_name' => $api_user->screen_name , 'user_id' => $content[$i]->id));
                }
                break;

            case 'Favorite':
                $service_url = $this->search;
                $post_value=array('q' => $bot->tag, 'result_type' => 'recent');
                $tweet_info=$this->connection->get($service_url,$post_value);
                foreach ($tweet_info as $k => $tweet)
                {
                    $content=$this->connection->post($this->favorite, array('id' => $tweet[0] -> id));
                }
                break;

            case 'DM Followers':
                $content = $this->connection->get('followers/list', array('screen_name'=> $api_user->screen_name ));
                foreach ($content as $k => $a) {
                    for ($i = 0; $i <20; $i++) {
                        $content = $this->connection->post('direct_messages/new', array('user_id' => $a[$i]->id, 'text' => $bot->message));

                    }
                }
                break;
        }

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