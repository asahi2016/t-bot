<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Twitter_model extends CI_Model
{

    var $accounts_table = 'accounts';

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
}