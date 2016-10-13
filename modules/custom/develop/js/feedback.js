(function($) {
    /*$('body').on('submit','#feedback-form',function(){
        var name = $('#feedback-form #edit-name');
        var text = $('#feedback-form #edit-text');
        var error_count = 0;
        if(name.val().length < 3){
            show_error(name);
            error_count++;
        }
        if(text.val().length < 3){
            show_error(text);
            error_count++;
        }

        if(error_count){
            return false;
        }
    });

    function show_error(obj){
        obj.css('border','1px solid red');
        setTimeout(function(){
            obj.css('border','1px solid #ccc');
        },3000);
    }*/

    var validate_obj = {
        errorClass: 'help-block text-right animated fadeInDown',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            console.log(jQuery(e));
            jQuery(e).parent().children('.help-block').remove();
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
        rules: {
            'name': {
                required: true,
                minlength: 3
            },
            'text': {
                required:true,
                minlength: 3
            }
        },
        messages: {
            'name': {
                required: 'Please enter a username',
                minlength: 'Your username must consist of at least 3 characters'
            },
            'text': {
                required: 'Please enter a feedback text',
                minlength: 'Your text must consist of at least 3 characters'
            }
        }
    };
    $('#feedback-form').validate(validate_obj);



})(jQuery);