<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="utf-8" />
    <title>Twitter Bots</title>
    <link media="screen" rel="Stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/global.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/selectbox.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>application/assets/css/font-awesome.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/html5shiv.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/respond.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/selectbox.js"></script>
</head>
<body>
<section class="wrap">
    <?php if(isset($_SESSION['user_id'])){?>
    <a href="<?php echo  base_url();?>web/logout" id="logout">Logout</a>
    <?php } ?>
    