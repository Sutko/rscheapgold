(function($) {

    $('body').on('click','#block-currency-block .currency-menu li:not(.active) a',function(){
        var code = $(this).attr('data-code');
        var sign = $(this).attr('data-sign');
        var link = $(this).parent();

        $.ajax({
            url: '/api/save_currency',
            type: 'get',
            dataType: 'json',
            data : {'currency' : code, 'sign' : sign},
            success : function(){
                $('#block-currency-block .currency-menu li.active').removeClass('active');
                link.addClass('active');
            }
        });

        if(($("#block-product-block").length > 0)){
            $.ajax({
                url: '/api/coverted_money',
                type: 'get',
                dataType: 'json',
                data : {'currency' : code},
                success : function(result){
                    var curr = sign+code;
                    console.log(curr);
                    $("#block-product-block .product span.selected-currency").html(sign);
                    $("#block-product-block .product span.c").html(curr);
                   //$("#block-product-block .product .changePriceSA").attr('placeholder',sign+'0');
                    $('#block-product-block #HiddenCurrency').val(code);
                    $.each(result.data,function(index, item){
                        $('#block-product-block #productItem-'+item.nid+' .field-price .field-value').html(item.price);
                        $('#block-product-block #HiddenPrice-'+item.nid).val(item.price);

                        var amount = $('#block-product-block #ChangePrice-'+item.nid).val();
                        amount = !amount ? 0 : amount;

                        var result = number_format(amount*item.price,2,'.','') > 0 ? number_format(amount*item.price,2,'.','') : '';
                        $('#block-product-block #priceResponse-'+item.nid).val(result);
                    });
                }
            });
        }

        if(($("#block-sell-block").length > 0)){
            $.ajax({
                url: '/api/coverted_money',
                type: 'get',
                dataType: 'json',
                data : {'currency' : code, 'type' : 0},
                success : function(result){
                    var curr = sign+code;
                    $("#block-sell-block span#currencyReplace").html(curr);
                    $('#sellPrice1').val(result.data[0].price);
                    $('#sellPrice2').val(result.data[1].price);
                    update_sell_result1();
                    update_sell_result2();
                }
            });
        }

        if(($("#block-packages-block").length > 0)){
            $.ajax({
                url: '/api/get_puckage_prices',
                type: 'get',
                dataType: 'json',
                data : {'currency' : code},
                success : function(result){
                    var curr = sign+code;
                    $("#block-packages-block .package span#currency").html(curr);
                    $.each(result,function(index, item){
                        $("#block-packages-block .package-"+item.id+" .field-price span.val").html(item['price']);
                    });
                }
            });
        }
    });

})(jQuery);

function number_format( number, decimals, dec_point, thousands_sep ) {
    var i, j, kw, kd, km;

    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

    return km + kw + kd;
}
