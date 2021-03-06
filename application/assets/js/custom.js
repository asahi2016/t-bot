$(document).ready(function () {

    var group   = $("div[id*='group']");
    var input_txt = $('input[type="text"]');
    var input_hidden = $('input[type="hidden"]');

    //Events Trigger
    $('form#twitterbots').submit(function () {

        $('#loader').show();

        $('span.error').remove();
        $('span.success').text('');

        $(this).attr('disabled','disabled');

        var error = fields_empty_checks();

        if(error){
            $(this).removeAttr('disabled');
            $('#loader').hide();
            return false;
        }else{

            var data = $('form#twitterbots').serialize();
            var baseUrl = $('#baseurl').val();

            $.post(baseUrl+"twitter/create", data, function(result){

                $(this).removeAttr('disabled');
                $('#loader').hide();
                
                var res = JSON.parse(result);

                if(res.success){
                    $('span.success').text(res.success);
                    setTimeout(function() {
                        window.location.href = baseUrl;
                    }, 5000);
                }else{
                    $('span.success').after(res);
                }
                $('html, body').animate({
                    scrollTop: $(".panel-heading").offset().top
                }, 1000);
            });

            return false;
        }

    });

    $('button[type="button"][name="add"]').click(function () {
        var error = fields_empty_checks();
        if(!error) {
            var total_bots = $('#totalbots').val();
            if (total_bots < 9) {
                var baseUrl = $('#baseurl').val();
                $.post(baseUrl + "twitter/additem", {bots: total_bots, action: 'add'}, function (result) {
                    var data = JSON.parse(result);
                    $("#group" + total_bots).after(data.content);
                    $('#totalbots').val('');
                    $('#totalbots').val(data.total_bots);
                });

            }
            else{
                $('html, body').animate({
                    scrollTop: $(".panel-heading").offset().top
                }, 1000);
                $("#max-error").text("You have reached maximum of 10 twitter bots");
            }
        }

        return false;
    });


    $(document).on('click','button.remove', function(){

        var total = '';
        $('button.remove').each(function (i) {
            total = total + i;
        });

        if(total > 0) {
            var remove_group_id = $(this).attr('rel');
            $('#group' + remove_group_id).remove();
            var group   = $("div[id*='group']");
            group.each(function(j,groups) {

                var bot = j+1;

                $(groups).find('label').text('Bot #'+bot);

                $(groups).attr('id','group'+j);

                $(groups).find('.remove').attr('rel', j);
                $(groups).find('.remove').attr('name', 'remove_'+j);

                $(groups).find('.search_phrase').attr('id', 'search_phrase_'+j);
                $(groups).find('.search_phrase').attr('name', 'search_phrase['+j+']');

                $(groups).find('.tweet_action').attr('id', 'tweet_action_'+j);
                $(groups).find('.tweet_action').attr('name', 'tweet_action['+j+']');

                $(groups).find('.message').attr('name', 'message['+j+']');


                $(groups).find('.start_time').attr('id', 'start_time_'+j);
                $(groups).find('.start_time').attr('name', 'start_time['+j+']');

                $(groups).find('.end_time').attr('id', 'end_time_'+j);
                $(groups).find('.end_time').attr('name', 'end_time['+j+']');

                $('#totalbots').val(j);
            });
        }

    });

    $(document).on('keypress', 'input[type="text"]' , function () {
        $(this).parent('div').next('span.error').remove();
    });

    function fields_empty_checks() {

        $('span.error').remove();
        var error_begin = '<span class="error">';
        var error_last = '</span>';
        var error = false;

        var input_txt = $('input[type="text"]');
        var input_hidden = $('input[type="hidden"]');
        var group   = $("div[id*='group']");
        var group1  = $("div[id*='g1']");

        group.each(function(k,groupele) {

            $(groupele).find(input_txt).each(function () {
                if($.trim($(this).val()) == '') {
                    var textval = ( $.trim($(this).parent('div.input-group').text()) == '@')?'This' : $(this).parent('div.input-group').text();
                    $(this).parent('div').after(error_begin + textval + ' field is required.' + error_last);
                    error = true;
                }
            });

            $(groupele).find(input_hidden).each(function () {
                if($.trim($(this).val()) == '') {
                    $(this).parent('a').after(error_begin + 'This field is required.' + error_last);
                    error = true;
                }
            });

        });
        group1.each(function(k,groupele) {
            $(groupele).find(input_txt).each(function () {
                if ($.trim($(this).val()) == '') {
                    var textval = ( $.trim($(this).parent('div.input-group').text()) == '@') ? 'This' : $(this).parent('div.input-group').text();
                    $(this).parent('div').after(error_begin + textval + ' field is required.' + error_last);
                    error = true;
                }
            });
        });

        return error;
    }

    $(document).on('click', 'li' ,function(){
        var action=$(this).attr('rel');
        var group_id = $(this).parents('div.active').attr('id');
        field_sets(action, group_id);
    });

    function field_sets(action, group_id) {

        $('span.error').remove();
        switch (action) {
            case 'Add to Twitter List':
                $('#'+group_id).find('.message').val('').attr('placeholder', 'Enter your list name ');
                $('#'+group_id).find('.search_phrase').attr('placeholder', '');
                $('#'+group_id).find('.search_phrase').val('').attr('readonly', false);
                $('#'+group_id).find('.message').val('').attr('readonly', false);
                $('#'+group_id).find('span.icon').html('#TagName');
                $('#'+group_id).find('span.message').html('List Name');

                break;
            case 'DM':
                $('#'+group_id).find('.message').val("").attr('readonly', false);
                $('#'+group_id).find('.search_phrase').val("").attr('readonly', false);
                $('#'+group_id).find('.search_phrase').attr('placeholder', '');
                $('#'+group_id).find('span.message').html('Message');
                $('#'+group_id).find('span.icon').html('@FollowerName');
                break;
            case 'Retweet':
                $('#'+group_id).find('.message').val('Not required').attr('readonly', true);
                $('#'+group_id).find('.search_phrase').val("").attr('readonly', false);
                $('#'+group_id).find('.search_phrase').attr('placeholder', '');
                $('#'+group_id).find('span.icon').html('#TagName');
                $('#'+group_id).find('span.message').html('@');
                break;
            case 'Follow User':
                $('#'+group_id).find('.message').val('Not required').attr('readonly', true);
                $('#'+group_id).find('.search_phrase').val("").attr('readonly', false);
                $('#'+group_id).find('span.message').html('@');
                $('#'+group_id).find('span.icon').html('@FollowerName');
                break;
            case 'RT with Comment':
                $('#'+group_id).find('.message').val("").attr('readonly', false);
                $('#'+group_id).find('.search_phrase').val("").attr('readonly', false);
                $('#'+group_id).find('.message').attr('placeholder', '');
                $('#'+group_id).find('span.icon').html('#TagName');
                $('#'+group_id).find('span.message').html('Comment');
                break;
            case 'Reply':
                $('#'+group_id).find('.search_phrase').val('Not required').attr('readonly', true);
                $('#'+group_id).find('.message').val("").attr('readonly', false);
                $('#'+group_id).find('.message').attr('placeholder', '');
                $('#'+group_id).find('span.icon').html('@');
                $('#'+group_id).find('span.message').html('Message');
                break;
            case 'Favorite':
                $('#'+group_id).find('.message').val('Not required').attr('readonly', true);
                $('#'+group_id).find('.search_phrase').val("").attr('readonly', false);
                $('#'+group_id).find('.search_phrase').attr('placeholder', '');
                $('#'+group_id).find('span.icon').html('#TagName');
                $('#'+group_id).find('span.message').html('@');
                break;
            case 'DM Followers':
                $('#'+group_id).find('.search_phrase').val('Not required').attr('readonly', true);
                $('#'+group_id).find('.message').val("").attr('readonly', false);
                $('#'+group_id).find('.message').attr('placeholder', '');
                $('#'+group_id).find('span.icon').html('@');
                $('#'+group_id).find('span.message').html('Message');
                break;
        }
    }

});