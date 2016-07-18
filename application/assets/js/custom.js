$(document).ready(function () {

    var input_txt = $('input[type="text"]');

    //Events Trigger
    $('form#twitterbots').submit(function () {

        var error = fields_empty_checks();

        if(error){
            return false;
        }

    });

    input_txt.keypress(function () {
        $(this).parent('div').next('span.error').remove();
    });

    function fields_empty_checks() {

        $('span.error').remove();
        var error_begin = '<span class="error">';
        var error_last = '</span>';

        var error = false;

        input_txt.each(function () {

            if($.trim($(this).val()) == ''){
                $(this).parent('div').after(error_begin+$(this).attr('placeholder')+' field is required.'+error_last);
                error = true;
            }

        });

        if($.trim($('#tweet_action').val()) == ''){
            $('#tweet_action').parent('a').after(error_begin+'Action field is required.'+error_last);
            error = true;
        }

        if($.trim($('#start_time').val()) == ''){
            $('#start_time').parent('a').after(error_begin+'Start time field is required.'+error_last);
            error = true;
        }

        if($.trim($('#end_time').val()) == ''){
            $('#end_time').parent('a').after(error_begin+'End time field is required.'+error_last);
            error = true;
        }
        
        return error;
    }

});
