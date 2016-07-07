<section class="form-section">
        <h1>Twitter Bots</h1>
        <h2>Written by @Asahitechnologies. Watch video tutorial to get started.</h2>
        <div class="twitter-form">
            <form accept-charset="utf-8" id="twitterbots" action="<?php echo  base_url(); ?>twitter/update" method="post">
                <div class="clearfix"></div>
                <div class="panel panel-red">
                    <fieldset>
                        <legend>Last <span>tweet sent by <b><?php echo $_SESSION['user']->displayname; ?></b></span></legend>
                        <p><?php echo $last_message; ?></p>
                    </fieldset>
                    <div class="panel-heading">
                        <h3 class="panel-title"><!-- <i class="fa fa-tasks"></i>  -->Enter your Twitter Apps Keys:</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Consumer Key" name="consumer_key" id="consumer_key">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Consumer Secret" name="consumer_secret" id="consumer_secret">
                                </div>
                            </div>
                        </div>
                        <div class="margin-bottom-25"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Access Token" name="access_token" id="access_token">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" placeholder="Access Secret" name="access_secret" id="access_secret">
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
                                            <input type="text" class="form-control" placeholder="Search phrase">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                            <span class="btn-select-value">Select an Item</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul>
                                                <li>--Select Action--</li>
                                                <li>English</li>
                                                <li class="selected">Afrikaans</li>
                                                <li>Albanian</li>
                                                <li>google.ae (United Arab Emirates)</li>
                                            </ul>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-25"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" placeholder="Message" name="message">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                            <span class="btn-select-value">Select an Item</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul>
                                                <li>--Start At--</li>
                                                <li>12 AM</li>
                                                <li class="selected">1 AM</li>
                                                <li>2 AM</li>
                                                <li>3 AM</li>
                                            </ul>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a class="btn btn-primary btn-select btn-select-light">
                                            <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                            <span class="btn-select-value">Select an Item</span>
                                            <span class='btn-select-arrow glyphicon glyphicon-chevron-down'></span>
                                            <ul>
                                                <li>--End At--</li>
                                                <li>12 AM</li>
                                                <li>1 AM</li>
                                                <li class="selected">2 AM</li>
                                                <li>3 AM</li>
                                            </ul>
                                        </a>
                                    </div>
                                </div>
                                <div class="margin-bottom-25"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="style2">See list of Twitter search operators that you can use to describe the bots. For support DM @labnol.</p>
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
                    <button type="submit" class="btn btn-success" value="Upgrade to Premium"> <i class="fa fa-money"></i> Upgrade to Premium</button>
                </div>
            </div>
            <div class="margin-bottom-25"></div>
            <div class="row">
                <div class="col-md-12">
                    <p class="style2">You can make 1 Twitter bot that can auto-reply/favorite/retweet tweets. Upgrade to Premium and make up to 5 bots that can follow users, send DMs and add users to Twitter lists. The free bot runs once per hour while premium Twitter bots run every 15 minutes.</p>
                </div>
            </div>
            </form>
        </div>
</section>

