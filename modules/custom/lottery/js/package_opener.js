(function($) {

var default_image = '/themes/sa_theme/cdn/img/gift.png';

$('body').on('click','#OpenButton',function(){
       var code = $(this).prev().val();
       var code_obj = $(this).prev();
       if(code.length != 5){
           replace_messge('The code must be 20 characters.','error');
           return false;
       }

        $.ajax({
            url: '/lottery/api/check',
            type: 'post',
            dataType: 'json',
            data : {'code' : code},
            success : function(data){
                if(data.error){
                    replace_messge(data.message,'error');
                    $('#block-package-opener-block .pre-image img').attr('src',default_image);
                    $('#block-package-opener-block .pre-image').removeClass('has-bg');
                } else {
                    replace_messge(data.message,'success');
                    $('#block-package-opener-block .pre-image').addClass('has-bg');
                    $('#block-package-opener-block .pre-image img').attr('src',data.image);
                }
            }
        });
    });

    function replace_messge(message,type){
        $('#block-package-opener-block .block-log span').remove();

        var temp = "<span class='message "+type+"'>"+message+"</span>";

        $('#block-package-opener-block .block-log').append(temp);
    }

})(jQuery);


