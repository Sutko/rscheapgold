(function ($) {
	
    $('body').on('click','.click_chat',function(){
    $zopim.livechat.departments.setVisitorDepartment("Sell your Rs3 Gold");
        $zopim.livechat.window.toggle();
 });

    $('#message_feedback').hide();

    $('#submit_feedback').click(function() {
        
        if($('#edit-name').val() == '' || $('#edit-text').val() == ''){
            $('#message_emty_feedback').show();
        }else{
            var name = $('#edit-name').val();
            var text = $('#edit-text').val();
            
            if(name.length >=3 && text.length >=3){
                $('#message_emty_feedback').hide();
                document.getElementById("edit-post-feedback").click();
                $('#message_feedback').show();
                $('#edit-name').val("");
                $('#edit-text').val("");
            }else{
                $('#message_emty_feedback').hide();
                $('#message_feedback').hide();
            }
        }
    });

    $('body.path-frontpage #block-footerbuynow a').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop : 0},800);
    });

    $('.sell1').click(function() {
        ga('send', 'pageview', '/click-RUNESCAPE-2007-sell-gold');
    });

    $('.sell2').click(function() {
        ga('send', 'pageview', '/click-RUNESCAPE-3-sell-gold');
    });

    $('#OpenButton').click(function() {
        ga('send', 'pageview', '/click-open-package');
    });



    $('#scroller .js-quickedit-page-title.page-header').html("RSCheapGold: the best RS Gold Store");

    $('.stickyHeader a').click(function(event) {
        event.preventDefault();
        $('html, body').animate({scrollTop : 0},600);
    });

    /* Fix modile menu bug */
    $('.navbar-toggle').on('click', function () {
        $('#navbar').css("overflow", "visible");
    });


    /* Animate.css pulse btn */
    var buyBtn = document.querySelector('.stickyHeader .buy-btn');

    if (buyBtn === null) {
        return;
    }

    buyBtn.classList.add('animated');
    buyBtn.classList.add('infinite');
    buyBtn.classList.add('pulse');


    /* Disable animations in mobile */
    var mq = window.matchMedia( "(max-width: 420px)" );
    if (mq.matches) {

        $('#animated-block-first').css({
            'top': '0',
            'opacity': '1'
        });

        $('#animated-block-second').css({
            'top': '0',
            'opacity': '1'
        });

        return;
    }


    /* Variables */
    var stickyHeader = document.getElementsByClassName('stickyHeader')[0];
    var elementsToAnimate = document.querySelectorAll('#scroller .articles-items .scroll-animated-block');
    var parentDivToAnimate = $('#scroller .articles-items');
    var locked = true;


    /*  ScrollMagic controller */
    var controller = new ScrollMagic.Controller();
    var controllerMini = new ScrollMagic.Controller({container: "#scroller .articles-items"});


    /* Header animation block */
    new ScrollMagic.Scene({})
        .setTween("#block-frontlotteryblock", 0.2, {
            x: -120,
            opacity: 1,
            delay: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);


    new ScrollMagic.Scene({})
        .setTween("#animated-block-first", 0.1, {
            y: -80,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);

    new ScrollMagic.Scene({})
        .setTween("#animated-block-second", 0.1, {
            y: -80,
            opacity: 1,
            ease: Linear.easeOut,
            delay: 0.2
        })
        .addTo(controller);


    /* Payment animation block */
    new ScrollMagic.Scene({
            triggerElement: "#block-views-block-payment-options-block-1 .block-title",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween("#block-views-block-payment-options-block-1 .block-title", 0.3, {
            y: -180,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);

    new ScrollMagic.Scene({
            triggerElement: "#block-views-block-payment-options-block-1 .block-title",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween("#block-views-block-payment-options-block-1 .view-header", 0.3, {
            y: -180,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);

    new ScrollMagic.Scene({
            triggerElement: "#block-views-block-payment-options-block-1 .view-content",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween("#block-views-block-payment-options-block-1 .view-content", 0.3, {
            y: -150,
            opacity: 1,
            ease: Linear.easeOut,
            delay: 0.3
        })
        .addTo(controller);


    /* Testimonials animation block */
    new ScrollMagic.Scene({
            triggerElement: "#block-views-block-feedback-list-block-2 .block-title",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween("#block-views-block-feedback-list-block-2 .block-title", 0.3, {
            y: -180,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);

    new ScrollMagic.Scene({
            triggerElement: "#block-views-block-feedback-list-block-2 .block-title",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween("#block-views-block-feedback-list-block-2 .view-header", 0.3, {
            y: -180,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);

    new ScrollMagic.Scene({
            triggerElement: "#block-views-block-feedback-list-block-2 .view-content",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween("#block-views-block-feedback-list-block-2 .view-content", 0.3, {
            y: -100,
            opacity: 1,
            ease: Linear.easeOut,
            delay: 0.3
        })
        .addTo(controller);


    /* Cornchat animation block */
    new ScrollMagic.Scene({
            triggerElement: ".path-frontpage .main-container h1.page-header",
            triggerHook: 'onEnter',
            offset: 50
        })
        .setTween(".path-frontpage .main-container h1.page-header", 0.3, {
            y: -180,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);

    new ScrollMagic.Scene({
            triggerElement: ".path-frontpage .main-container h1.page-header",
            triggerHook: 'onEnter',
            offset: 100
        })
        .setTween(".path-frontpage .main-container #block-blog-block .block-title", 0.3, {
            y: -180,
            opacity: 1,
            ease: Linear.easeOut
        })
        .addTo(controller);


    /* Hide button Buy in the header when footer is active*/
    new ScrollMagic.Scene({
            triggerElement: 'footer.footer',
            triggerHook: 'onEnter',
            offset: 20
        })
        .addTo(controller)
        .setTween(".stickyHeader", 0.1, {
            opacity: 0,
            ease: Linear.easeOut
        });


    /* Slider with animation */
    $('body').bind('mousewheel', function (e) {
        if (window.pageYOffset || document.documentElement.scrollTop > 50) {
            stickyHeader.classList.add('visibleHeader');
        } else {
            stickyHeader.classList.remove('visibleHeader');
        }

        if (!locked) {
            var wheelDelta = e.originalEvent.wheelDelta;
            var scrTop = parentDivToAnimate.scrollTop();
            var delta = scrTop - wheelDelta;

            if ((scrTop === 700) && (wheelDelta < 0)) {
                locked = true;
                return true;
            }

            if ((scrTop === 0) && (wheelDelta > 0)) {
                locked = true;
                return true;
            }

            $(parentDivToAnimate).stop().animate( {
                scrollTop : delta,
                easing: "easeout"
            } , 15);

            return false;
        }
    });

    $('body').bind('MozMousePixelScroll', function (e) {
        if (window.pageYOffset || document.documentElement.scrollTop > 50) {
            stickyHeader.classList.add('visibleHeader');
        } else {
            stickyHeader.classList.remove('visibleHeader');
        }

        if (!locked) {
            var wheelDelta = e.originalEvent.detail;
            var scrTop = parentDivToAnimate.scrollTop();
            var delta = scrTop + wheelDelta;

            if ((scrTop === 700) && (wheelDelta > 0)) {
                locked = true;
                return true;
            }

            if ((scrTop === 0) && (wheelDelta < 0)) {
                locked = true;
                return true;
            }

            $(parentDivToAnimate).stop().animate( {
                scrollTop : delta,
                easing: "easeout"
            } , 15);

            return false;
        }
    });

    new ScrollMagic.Scene({
            triggerElement: "#scroller .articles-items",
            triggerHook: 'onEnter',
            offset: 10
        })
        .setTween("#scroller .articles-items", 0.3, {
            y: -150,
            opacity: 1,
            ease: Linear.easeOut,
            delay: 0.3
        })
        .addTo(controller);

    new ScrollMagic.Scene({
            triggerElement: "#scroller .articles-items",
            offset: 560,
            duration: 1000
        })
        .setTween("#scroller .articles-items", 0.3, {})
        .addTo(controller)
        .on('enter', function () {
            locked = false;
        })
        .on('progress', function () {
            locked = false;
        })
        .on('leave', function () {
            locked = true;
        });


    new ScrollMagic.Scene({
            triggerElement: elementsToAnimate[0],
            duration: 300,
            triggerHook: 'onLeave',
            offset: -20
        })
        .addTo(controllerMini)
        .setTween(elementsToAnimate[0], 0.1, {
            opacity: 0,
            ease: Linear.easeOut
        });

    new ScrollMagic.Scene({
            triggerElement: elementsToAnimate[1],
            duration: 320,
            triggerHook: 'onLeave',
            offset: -20
        })
        .addTo(controllerMini)
        .setTween(elementsToAnimate[1], 0.1, {
            opacity: 0,
            ease: Linear.easeOut
        });

    new ScrollMagic.Scene({
            triggerElement: elementsToAnimate[2],
            triggerHook: 'onEnter',
            offset: 20
        })
        .addTo(controllerMini)
        .setTween(TweenMax.fromTo(elementsToAnimate[2], 0.1,
            {
                opacity: 0
            },
            {
                opacity: 1
            })
        );

    new ScrollMagic.Scene({
            triggerElement: elementsToAnimate[3],
            triggerHook: 'onEnter',
            offset: 20
        })
        .addTo(controllerMini)
        .setTween(TweenMax.fromTo(elementsToAnimate[3], 0.1,
            {
                opacity: 0
            },
            {
                opacity: 1
            })
        );


})(jQuery);