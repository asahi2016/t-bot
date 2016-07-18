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

?>
<span class="success" style="color: green;"><?php echo isset($success)? $success: '';?></span>
<section class="form-section">
        <h1>Twitter Bots</h1>
        <h2>Written by @Asahitechnologies.</h2>
        <div class="twitter-form">
            <form accept-charset="utf-8" id="twitterbots" action="<?php echo  base_url(); ?>twitter/create" method="post">
                <div class="clearfix"></div>
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <h3 class="panel-title"><!-- <i class="fa fa-tasks"></i>  -->Enter your Twitter Apps Keys:</h3>
                    </div>
                    <?php echo form_error('authcheck'); ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Consumer Key" name="consumer_key" id="consumer_key" value="<?php echo  isset($consumer_key)? $consumer_key :''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Consumer Secret" name="consumer_secret" id="consumer_secret" value="<?php echo  isset($consumer_secret)? $consumer_secret :''; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="margin-bottom-25"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Access Token" name="access_token" id="access_token" value="<?php echo  isset($access_token)? $access_token :''; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Access Secret" name="access_secret" id="access_secret" value="<?php echo  isset($access_secret)? $access_secret :''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>What will the Twitter bots do?</h3>
                                <label>Bot #1  </label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" placeholder="Search phrase" name="search_phrase" id="search_phrase" value="<?php echo  isset($search_phrase)? $search_phrase :''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input" id="tweet_action" name="tweet_action" value="<?php echo  isset($tweet_action)? $tweet_action :''; ?>" />
                                            <span class="btn-select-value">--Select Action--</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul style="overflow-y: scroll;overflow-x: hidden;">
                                                <?php
                                                foreach ($tweet_services as $service_key => $service){
                                                    $class = '';
                                                    if(isset($tweet_action) && !empty($tweet_action)){
                                                        if($tweet_action == $service_key){
                                                            $class = 'class="selected"';
                                                        }
                                                    }
                                                    echo "<li rel='$service_key' $class >$service</li>";

                                                }
                                                ?>
                                            </ul>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-25"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" placeholder="Message" name="message" value="<?php echo  isset($message)? $message :''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input" id="start_time" name="start_time" value="<?php echo  isset($start_time)? $start_time :''; ?>" />
                                            <span class="btn-select-value">Start at</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul style="height: 100px;">
                                                <?php
                                                foreach ($times as $st_key => $st_time){
                                                    $class = '';
                                                    if(isset($start_time) && !empty($start_time)){
                                                        if($start_time == $st_key){
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
                                            <input type="hidden" class="btn-select-input" id="end_time" name="end_time" value="<?php echo  isset($end_time)? $end_time :''; ?>" />
                                            <span class="btn-select-value">End at</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul style="height: 100px;">
                                                <?php
                                                foreach ($times as $ed_key => $ed_time){
                                                    $class = '';
                                                    if(isset($end_time) && !empty($end_time)){
                                                        if($end_time == $ed_key){
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
            <div class="margin-bottom-25"></div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" value="Create Twitter Bots" class="btn btn-primary m-right10" name="botsubmit"> <i class="fa fa-twitter-square"></i> Create Twitter Bots</button>
                    <!--<button type="submit" class="btn btn-success" value="Upgrade to Premium"> <i class="fa fa-money"></i> Upgrade to Premium</button>-->
                </div>
            </div>
            <div class="margin-bottom-25"></div>
            <div class="row">
                <div class="col-md-12">
                    <!--<p class="style2">You can make 1 Twitter bot that can auto-reply/favorite/retweet tweets. Upgrade to Premium and make up to 5 bots that can follow users, send DMs and add users to Twitter lists. The free bot runs once per hour while premium Twitter bots run every 15 minutes.</p>-->
                </div>
            </div>
            </form>
        </div>
</section>
<script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/custom.js"></script>


