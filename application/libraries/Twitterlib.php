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

    public function post($msg)
    {

        if ($msg) {

            // Post Update
            $content = $this->connection->post('statuses/update', array('status' => $msg));

            if ($content) {

                if (isset($content->id) && !empty($content->id) && is_numeric($content->id)) {
                    return $content;
                }

            }

            return false;
        }
    }


    public function check(){

        $credentials = $this->connection->get('account/verify_credentials');

        if(isset($credentials->id) && !empty($credentials->id)){

            return true;

        }

        return false;

    }

}
