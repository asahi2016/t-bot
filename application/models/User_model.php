<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    var $user_table = 'users';

    // insert user infor if the user info not present in users table
    public function get_user_by_social_identifier($identifier){

        $query = $this->db->where('identifier', $identifier)
                          ->limit(1)
                          ->get($this->user_table);

       return  $query->row();

    }

    // insert user infor if the user info not present in users table
    public function get_user_by_id($user_id){

        $query = $this->db->where('uid', $user_id)
            ->limit(1)
            ->get($this->user_table);

        return  $query->row();

    }


    // insert user infor if the user info not present in users table
    public function insert_user($user){

        if($this->db->insert($this->user_table, $user)){

            return  $this->db->insert_id();

        }

        return false;

    }

    public function prepare_user_info_array($user, $provider, $login_type)
    {

        $user_details = array();

        if ($user) {

            $user_details['username'] = isset($user->username) ? $user->username : '';
            $user_details['firstname'] = ($user->firstName) ? $user->firstName : '';
            $user_details['lastname'] = ($user->lastName) ? $user->lastName : '';
            $user_details['email'] = ($user->email) ? $user->email : '';
            $user_details['email_verified'] = ($user->emailVerified) ? $user->emailVerified : 0;
            $user_details['displayname'] = ($user->displayName) ? $user->displayName : '';
            $user_details['description'] = ($user->description) ? $user->description : '';
            $user_details['gender'] = ($user->gender) ? $user->gender : '';
            $user_details['language'] = ($user->language) ? $user->language : '';
            $user_details['age'] = ($user->age) ? $user->age : 0;
            $user_details['birthday'] = ($user->birthDay) ? $user->birthDay : 0;
            $user_details['birthmonth'] = ($user->birthMonth) ? $user->birthMonth : 0;
            $user_details['birthyear'] = ($user->birthYear) ? $user->birthYear : 0;
            $user_details['phone'] = ($user->phone) ? $user->phone : '';
            $user_details['address'] = ($user->address) ? $user->address : '';
            $user_details['country'] = ($user->country) ? $user->country : '';
            $user_details['region'] = ($user->region) ? $user->region : '';
            $user_details['city'] = ($user->city) ? $user->city : '';
            $user_details['zip'] = ($user->zip) ? $user->zip : '';
            $user_details['provider'] = $provider;
            $user_details['identifier'] = ($user->identifier) ? $user->identifier : '';
            $user_details['websiteurl'] = ($user->webSiteURL) ? $user->webSiteURL : '';
            $user_details['profileurl'] = ($user->profileURL) ? $user->profileURL : '';
            $user_details['photo'] = ($user->photoURL) ? $user->photoURL : '';
            $user_details['status'] = 0;
            $user_details['rid'] = 2;
            $user_details['login_type'] = $login_type;
            $user_details['access_token'] = md5($user->email);
            $user_details['updated'] = date('Y-m-d H:i:s');
        }

        return $user_details;

    }

}