(function($) {
    $('body').on('keyup mousewheel','#sellChange1',function(){
       update_sell_result1();
    });

    $('body').on('keyup mousewheel','#sellChange2',function(){
        update_sell_result2();
    });

    var validate_obj1 = {
        errorClass: 'help-block text-right animated fadeInDown',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            jQuery(e).parents('.form-group').append(error);
        },
        highlight: function(e) {
            jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
            jQuery(e).closest('.help-block').remove();
        },
        success: function(e) {
            jQuery(e).closest('.form-group').removeClass('has-error');
            jQuery(e).closest('.help-block').remove();
        },
        submitHandler: function(form) {
          sell_message_to_chat(1);
        },
        rules: {
            'ammount_runescape_2007': {
                required: true,
                digits: true
            }
        },
        messages: {
            'ammount_runescape_2007': {
                required: 'Please Enter amount in Millions',
                digits: 'Please enter only digits!'
            }
        }
    };

    var validate_obj2 = {
        errorClass: 'help-block text-right animated fadeInDown',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            jQuery(e).parents('.form-group').append(error);
        },
        highlight: function(e) {
            jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
            jQuery(e).closest('.help-block').remove();
        },
        success: function(e) {
            jQuery(e).closest('.form-group').removeClass('has-error');
            jQuery(e).closest('.help-block').remove();
        },
        submitHandler: function(form) {
            sell_message_to_chat(2);
        },
        rules: {
            'ammount_runescape_3': {
                required:true,
                digits: true
            }
        },
        messages: {
            'ammount_runescape_3': {
                required: 'Please Enter amount in Millions',
                digits: 'Please enter only digits!'
            }
        }
    };

    $('#SellForm1').validate(validate_obj1);
    $('#SellForm2').validate(validate_obj2);

})(jQuery);

function update_sell_result1(){
    var amount = jQuery('#sellChange1').val();
    var price  = jQuery('#sellPrice1').val();
    amount = !amount ? 0 : amount;
    jQuery('#sellReplace1').html(number_format(amount*price,2,'.',''));
}

function update_sell_result2(){
    var amount = jQuery('#sellChange2').val();
    var price  = jQuery('#sellPrice2').val();
    amount = !amount ? 0 : amount;
    jQuery('#sellReplace2').html(number_format(amount*price,2,'.',''));
}

function sell_message_to_chat(type){
    var sellChange1 = parseInt(jQuery('#sellChange1').val());
    var sellChange2 = parseInt(jQuery('#sellChange2').val());
    var total_price1 = jQuery('#sellReplace1').html();
    var total_price2 = jQuery('#sellReplace2').html();
    var select_code = jQuery('#block-currency-block .currency-menu li.active a').attr('data-code');

    var title_1 = jQuery('#productTitle1').html();
    var title_2 = jQuery('#productTitle2').html();

    var text_1 = "Hi, I'm looking to sell "+sellChange1+"M "+title_1+" for "+total_price1+' '+select_code;
    var text_2 = "Hi, I'm looking to sell "+sellChange2+"M "+title_2+" for "+total_price2+' '+select_code;

    $zopim.livechat.departments.setVisitorDepartment("Sell your Rs3 Gold");
    if(type == 1){
        $zopim.livechat.say(text_1);
    } else {
        $zopim.livechat.say(text_2);
    }

}