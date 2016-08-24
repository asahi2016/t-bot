<?php

$tweet_services = array('Add to Twitter List' => 'Add to Twitter List',
    'DM Followers' => 'DM New Followers',
    'Favorite' => 'Favorite Tweet',
    'Follow User' => 'Follow User',
    'Retweet' => 'Retweet Tweet',
    'RT with Comment' => 'RT with Comment',
    'DM' => 'Send Private DM',
    'Reply' => 'Send Public Reply'
);

$times = array(
    '12 AM','01 AM','02 AM','03 AM','04 AM','05 AM','06 AM','07 AM','08 AM','09 AM','10 AM','11 AM',
    '12 PM','01 PM','02 PM','03 PM','04 PM','05 PM','06 PM','07 PM','08 PM','09 PM','10 PM','11 PM');

$bots = array(1);

?>

<section class="form-section">
        <h1>Twitter Bots</h1>
        <h2>Written by @Asahitechnologies.</h2>
        <div class="twitter-form">
            <div class="row">
                <div class="col-md-12">
                    <p class="style2">You can make a maximum of 10 Twitter bots. This free Twitter bots runs every 15 minutes.</p>
                </div>
            </div>
            <div class="margin-bottom-25"></div>
            <form accept-charset="utf-8" id="twitterbots" action="<?php echo  base_url(); ?>twitter/create" method="post">
                <div class="clearfix"></div>
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <h3 class="panel-title"><!-- <i class="fa fa-tasks"></i>  -->Enter your Twitter Apps Keys:</h3>
                    </div>
                    <span class="success" style="color: green;"><?php echo isset($success)? $success: '';?></span>
                    <span style="color:red;" id="max-error"></span>
                    <?php echo form_error('authcheck'); ?>
                    <div class="panel-body">
                        <div id="g1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Consumer Key</span>
                                    <input type="text" class="form-control" name="consumer_key" id="consumer_key" value="<?php echo  isset($consumer_key)? $consumer_key :''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Consumer Secret</span>
                                    <input type="text" class="form-control" name="consumer_secret" id="consumer_secret" value="<?php echo  isset($consumer_secret)? $consumer_secret :''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="margin-bottom-25"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Access Token</span>
                                    <input type="text" class="form-control" name="access_token" id="access_token" value="<?php echo  isset($access_token)? $access_token :''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Access Secret</span>
                                    <input type="text" class="form-control" name="access_secret" id="access_secret" value="<?php echo  isset($access_secret)? $access_secret :''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>What will the Twitter bots do?</h3>
                                <?php

                                foreach ($bots as $bkey => $bot){
                                  $display = 'display : block';
                                  $class = '';
                                  if($bot > 1){

                                      $show  = false;
                                      if(isset($search_phrase[$bkey]))
                                          $show = true;
                                      elseif (isset($search_phrase[$bkey]))
                                          $show = true;
                                      elseif (isset($tweet_action[$bkey]))
                                          $show = true;
                                      elseif (isset($message[$bkey]))
                                          $show = true;
                                      elseif (isset($start_time[$bkey]))
                                          $show = true;
                                      elseif (isset($end_time[$bkey]))
                                          $show = true;

                                      if(!$show) $display = 'display : none';
                                      else $class = 'class="active"';
                                      
                                  }elseif($bot == 1){
                                      $class = 'class="active"';
                                  }
                                ?>
                                <div id="group<?=$bkey?>" style="<?=$display;?>" <?=$class?>>
                                <label>Bot #<?=$bot?>  </label>
                                <div style="float: right">
                                <button type="button" value="Remove" class="btn-sm btn-primary remove" name="remove_<?=$bkey?>" rel="<?=$bkey?>"> <i class="fa fa-twitter-square"></i> Remove</button>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input tweet_action" id="tweet_action_<?=$bkey?>" name="tweet_action[<?=$bkey?>]" value="<?php echo isset($tweet_action[$bkey])? $tweet_action[$bkey] :''; ?>" />
                                            <span class="btn-select-value">--Select Action--</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul style="overflow-y: scroll;overflow-x: hidden;">
                                                <?php
                                                foreach ($tweet_services as $service_key => $service){
                                                    $class = '';
                                                    if(isset($tweet_action[$bkey]) && !empty($tweet_action[$bkey])){
                                                        if($tweet_action[$bkey] == $service_key){
                                                            $class = 'class="selected"';
                                                        }
                                                    }
                                                    echo "<li rel='$service_key' $class >$service</li>";

                                                }
                                                ?>
                                            </ul>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon icon">@</span>
                                            <input type="text" class="form-control search_phrase" placeholder="Search phrase" name="search_phrase[<?=$bkey?>]" id="search_phrase_<?=$bkey?>" value="<?php echo  isset($search_phrase[$bkey])? $search_phrase[$bkey] :''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-bottom-25"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon message">@</span>
                                            <input type="text" class="form-control message" placeholder="Message" name="message[<?=$bkey?>]" value="<?php echo isset($message[$bkey])? $message[$bkey] :''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input start_time" id="start_time_<?=$bkey?>" name="start_time[<?=$bkey?>]" value="<?php echo isset($start_time[$bkey])? $start_time[$bkey] :''; ?>" />
                                            <span class="btn-select-value">Start at</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul style="height: 100px;">
                                                <?php
                                                foreach ($times as $st_key => $st_time){
                                                    $class = '';
                                                    if(isset($start_time[$bkey]) && !empty($start_time[$bkey])){
                                                        if($start_time[$bkey] == $st_key){
                                                         $class = 'class="selected"';
                                                        }
                                                    }
                                                    echo "<li rel='$st_key' $class >$st_time</li>";

                                                }
                                                ?>
                                            </ul>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input end_time" id="end_time_<?=$bkey?>" name="end_time[<?=$bkey?>]" value="<?php echo isset($end_time[$bkey])? $end_time[$bkey] :''; ?>" />
                                            <span class="btn-select-value">End at</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul style="height: 100px;">
                                                <?php
                                                foreach ($times as $ed_key => $ed_time){
                                                    $class = '';
                                                    if(isset($end_time[$bkey]) && !empty($end_time[$bkey])){
                                                        if($end_time[$bkey] == $ed_key){
                                                            $class = 'class="selected"';
                                                        }
                                                    }
                                                    echo "<li rel='$ed_key' $class >$ed_time</li>";

                                                }
                                                ?>
                                            </ul>
                                        </a>
                                    </div>
                                </div>
                                </div>
                                <?php } ?>
                                <div class="margin-bottom-25"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <!--<p class="style2">See list of Twitter search operators that you can use to describe the bots. For support DM @labnol.</p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="totalbots" id="totalbots" class="totalbots" value="0">
                <input type="hidden" name="botsubmit" id="botsubmit" class="botsubmit" value="1">
                <input type="hidden" id="baseurl" value="<?php echo base_url();?>">
            <div class="margin-bottom-25"></div>
            <div class="row">
                <div class="col-md-12 margin">
                    <button type="button" value="Add another bot item" class="btn btn-primary m-right10" name="add"> <i class="fa fa-twitter-square"></i> Add another bot item</button>
                    <button type="submit" value="Create Twitter Bots" class="btn btn-primary m-right10" name="botsubmit"> <i class="fa fa-twitter-square"></i> Create Twitter Bots</button>
                    <!--<button type="submit" class="btn btn-success" value="Upgrade to Premium"> <i class="fa fa-money"></i> Upgrade to Premium</button>-->
                    <img src="<?php echo  base_url(); ?>application/assets/images/loading.gif" alt="Loading...." height="30" width="30" style="display: none;" id="loader">
                </div>
            </div>
            </form>
        </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/custom.js"></script>