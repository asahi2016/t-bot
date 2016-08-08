<?php

//Initiating the curl
$url="http://dev.asahitechnologies.com/t-bot/services";
//$url = "https://www.gmail.com";
$ch = curl_init($url);

//User/Browser Agent setting
$userAgent = 'Mozilla/16.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

//Curl SSL setting, this is very important for https url's
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

//Username and password of the site to access the url
//$username='admin@whysciencenow.com';
//$password='admin123';

//$username='student.teststudent1@gmail.com';
//$password='test@123';

//curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

//Curl Execution
$data = curl_exec($ch);
echo $data;

//Curl & File handler closed
curl_close($ch);

?>