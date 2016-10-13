(function($) {
    $('body').on('keyup mousewheel','.changeAmountSA',function(){
       var sign = $('#block-currency-block li.active a').attr('data-sign');
       var amount = $(this).val();
       amount = !amount ? 0 : amount;
       var price = $(this).parent().children('.hidden_price').val();

       var result = number_format(amount*price,2,'.','') > 0 ? number_format(amount*price,2,'.','') : '';

       $(this).parent().children('.changePriceSA').val(result);

        var eligable = $(this).parent().next();
        var carrency = $('#HiddenCurrency').val();
        change_eligable(result,carrency,eligable);
    });

    $('body').on('keyup mousewheel','.changePriceSA',function(){
        var sign = $('#block-currency-block li.active a').attr('data-sign');
        var price = $(this).val();
        var item_price = $(this).parent().children('.hidden_price').val();
        item_price = !item_price ? 0 : item_price;
        var result_amount = number_format(price/item_price,2,'.','');
        var it = number_format(parseInt(result_amount)*item_price,2,'.','');
        console.log(it);
        $(this).parent().children('.changeAmountSA').val(parseInt(result_amount));
        var eligable = $(this).parent().next();
        var carrency = $('#HiddenCurrency').val();
        change_eligable(price,carrency,eligable);
        setTimeout(set_correct_price, 1000);
    });



    $('body').on('click','.field-quick-buy ul li a',function(){
        var amount = $(this).attr('data-val');
        var field_counter = $(this).parent().parent().parent().prev().prev().prev();
        field_counter.children('.changeAmountSA').val(amount);
        var item_price = field_counter.children('.hidden_price').val();
        var result_amount = number_format(item_price*amount,2,'.','');
        field_counter.children('.changePriceSA').val(result_amount);

        var eligable = $(this).parent().parent().parent().prev().prev();
        var carrency = $('#HiddenCurrency').val();
        change_eligable(result_amount,carrency,eligable);
        return false;
    });

    function change_eligable(price,currency,eligable) {
        $.ajax({
            url: '/api/get_eligible_to_win',
            type: 'get',
            dataType: 'json',
            data : {'price' : price,'currency':currency},
            success : function(data){
                eligable.html(data.message);
            }
        });
    }

    $('#productItem-4 .btn.btn-primary').click(function() {
        ga('send', 'pageview', '/click-RUNESCAPE-2007-buy-now');
    });

    $('#productItem-5 .btn.btn-primary').click(function() {
        ga('send', 'pageview', '/click-RUNESCAPE-3-buy-now');
    });

    $('.buy-btn.animated.infinite.pulse').click(function() {
        ga('send', 'pageview', '/click-buy-now-scroll');
    });

    function set_correct_price(){
        
        if($("#priceResponse-4").val() != 0){
            var price = $("#priceResponse-4").val();
            var carrency = $('#HiddenPrice-4').val();
            var million = $('#ChangePrice-4').val();
            var currect_price = number_format(parseInt(million)*carrency,2,'.','');
            $("#priceResponse-4").val(currect_price);
        }

        if($("#priceResponse-5").val() != 0){
            var price = $("#priceResponse-5").val();
            var carrency = $('#HiddenPrice-5').val();
            var million = $('#ChangePrice-5').val();
            var currect_price = number_format(parseInt(million)*carrency,2,'.','');
            $("#priceResponse-5").val(currect_price);
        }

    }

    var product1 = {
        errorClass: 'help-block text-right animated fadeInDown',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            jQuery(e).parents('.field-counter').append(error);
        },
        highlight: function(e) {
            jQuery(e).parents('.field-counter').removeClass('has-error').addClass('has-error');
            jQuery(e).closest('.help-block').remove();
        },
        success: function(e) {
            jQuery(e).parents('.field-counter').removeClass('has-error');
            jQuery(e).closest('.help-block').remove();
        },
        rules: {
            'amount': {
                required: true
            }
        },
        messages: {
            'amount': {
                required: 'Please Enter amount in Millions'
            }
        }
    };
    $('#Product0').validate(product1);
    $('#Product1').validate(product1);

})(jQuery);
