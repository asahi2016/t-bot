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

    public function __construct()
    {
       $this->connection = new TwitterOAuth(CONSUMER_KEY , CONSUMER_SECRET , TWIT_OAUTH_TOKEN , TWIT_OAUTH_TOKEN_SECRET);
    }

    public function tweetpost($msg)
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

}
