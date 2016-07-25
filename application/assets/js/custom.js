$(document).ready(function () {

    var group   = $("div[id*='group']");
    var input_txt = $('input[type="text"]');
    var input_hidden = $('input[type="hidden"]');

    //Events Trigger
    $('form#twitterbots').submit(function () {

        var error = fields_empty_checks();

        if(error){
            return false;
        }else{
            group.each(function(i) {
                if (!$(this).hasClass('active')) {
                    $(this).remove();
                }else{
                    $('#totalbots').val(i);
                }
            });

            return true;
        }

    });

    $('button[type="button"]').click(function () {
        var error = fields_empty_checks();
        if(!error){
           var open = true;
           group.each(function(i) {
               var id = $(this).attr('id');
               if(!$('#'+id).hasClass('active')){
                   if(open) {
                       $('#'+id).addClass('active');
                       $('#'+id).css('display', 'block');
                       open = false;
                   }
               }
           });
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
        var present = Array();

        /*group.each(function(i,group) {

            $(group).find(input_txt).each(function () {
                if($.trim($(this).val()) != '') {
                    present[i] = 1;
                }
            });

            $(group).find(input_hidden).each(function () {
                if($.trim($(this).val()) != '') {
                    present[i] = 1;
                }
            });

        });

        var full_check = false;
        group.each(function(j) {
            if (present[j]) {
                full_check = true;
            }
        });

        if(!full_check){
            $('button[type="submit"]').after(error_begin+'Please enter bot fields informations.'+error_last);
            error = true;
        }

         group.each(function(i,group) {
                 $(group).find(input_txt).each(function () {
                 if($.trim($(this).val()) != '') {
                 present[i] = 1;
                 }
                 });

                 $(group).find(input_hidden).each(function () {
                 if($.trim($(this).val()) != '') {
                 present[i] = 1;
                 }
                 });
         });

        */

        group.each(function(i,group) {

            var id = $(group).attr('id');

            if($('#'+id).hasClass('active')){
                present[i] = 1;
            }
        });

        group.each(function(k,groupele) {

            if(present[k]) {

                $(groupele).find(input_txt).each(function () {
                    if($.trim($(this).val()) == '') {
                        $(this).parent('div').after(error_begin + $(this).attr('placeholder') + ' field is required.' + error_last);
                        error = true;
                    }
                });

                $(groupele).find(input_hidden).each(function () {
                    if($.trim($(this).val()) == '') {
                        $(this).parent('a').after(error_begin + 'This field is required.' + error_last);
                        error = true;
                    }
                });

            }

        });

        return error;
    }

});
