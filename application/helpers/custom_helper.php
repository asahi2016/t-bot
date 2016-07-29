<?php
/**
 * Created by PhpStorm.
 * User: asahi-qa2
 * Date: 29/7/16
 * Time: 11:18 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');


if ( ! function_exists('get_ip_address_info'))
{
    /**
     * Element
     *
     * Lets you determine whether an array index is set and whether it has a value.
     * If the element is empty it returns NULL (or whatever you specify as the default value.)
     *
     * @param	string
     * @param	object
     * @param	mixed
     * @return	mixed	depends on what the array contains
     */
    function get_ip_address_info($ip = null)
    {

        $url = ($ip) ? 'http://ipinfo.io/'.$ip : 'http://ipinfo.io';

        $ip_info = file_get_contents($url);

        $ip_info = json_decode($ip_info);

        return $ip_info;

    }
}


if ( ! function_exists('get_user_ip'))
{
    /**
     * Element
     *
     * Lets you determine whether an array index is set and whether it has a value.
     * If the element is empty it returns NULL (or whatever you specify as the default value.)
     *
     * @param	string
     * @param	object
     * @param	mixed
     * @return	mixed	depends on what the array contains
     */
    function get_user_ip()
    {

        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return trim($ipaddress);

    }
}