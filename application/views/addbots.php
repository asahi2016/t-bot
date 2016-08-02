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
                <span class="input-group-addon">@</span>
                <input type="text" class="form-control search_phrase" placeholder="Search phrase" name="search_phrase[<?=$bkey?>]" id="search_phrase_<?=$bkey?>" value="<?php echo  isset($search_phrase[$bkey])? $search_phrase[$bkey] :''; ?>">
            </div>
        </div>
    </div>
    <div class="margin-bottom-25"></div>
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon">@</span>
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