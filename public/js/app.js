$(document).ready(function () {
    // tooltip activation
    $("[data-toggle=tooltip]").tooltip();

    // EventController Favorite btn
    $('.favorite_btn').click(function () {
        $('.favorite_btn').tooltip('hide');
        if($('.favorite').hasClass('active')) {
            var behavior = 'unfavorite';
        } else {
            var behavior = 'favorite';
        }

        toggleTooltip(behavior);
        $.ajax({
            url: '/event/' + id + '/'+ behavior,
            type: 'GET',
            cache : true,
            dataType: "json",
            error: function(xhr, textStatus, errorThrown) {
                //
            },
            success: function(data) {
                if(data.success) {
                    $('.favorite').toggleClass('active');
                }
            }
        });
    });

    $('.follow_btn').click(function () {
        $('.follow_btn').tooltip('hide');
        if($('.follow').hasClass('active')) {
            var behavior = 'unfollow'
        } else {
            var behavior = 'follow'
        }
        toggleTooltip(behavior);
        $.ajax({
            url: '/event/' + id + '/'+ behavior,
            type: 'GET',
            cache : true,
            dataType: "json",
            error: function(xhr, textStatus, errorThrown) {
                //
            },
            success: function(data) {
                if(data.success) {
                    $('.follow').toggleClass('active');
                }
            }
        });
    });

//    $('.subscribe_btn').click(function () {
//        $('.subscribe_btn').tooltip('hide');
//        if($('.subscribe').hasClass('active')) {
//            var behavior = 'unsubscribe'
//        } else {
//            var behavior = 'subscribe'
//        }
//        toggleTooltip(behavior);
//        $.ajax({
//            url: '/event/' + id + '/'+ behavior,
//            type: 'GET',
//            cache : true,
//            dataType: "json",
//            error: function(xhr, textStatus, errorThrown) {
//                //
//            },
//            success: function(data) {
//                if(data.success) {
//                    $('.subscribe').toggleClass('active');
//                }
//                alert(data.message);
//                // to insert href.location line here in order to activate the Knet !!!! Usama - 24.3.14
//            }
//        });
//    });

    jQuery(function($) {
        $("tr[data-link]").click(function() {
            window.location = this.dataset.link
        });
    });

    $('#myCarousel').on('slid.bs.carousel', function () {

        // Get currently selected item
        var orderSlide = $('#myCarousel .carousel-inner .item.active').data('order');

        // Deactivate all nav links
        $('.tag').removeClass('active-tab-slide');

        var slideNumber = "#slide" + orderSlide;

        $(slideNumber).addClass('active-tab-slide');
    });

    $( "#slide0" ).on( "click", function() {

        $('.carousel').carousel(0);
        activatTab($(this));
    });

    $( "#slide1" ).on( "click", function() {

        $('.carousel').carousel(1);
        activatTab($(this));
    });

    $( "#slide2" ).on( "click", function() {

        $('.carousel').carousel(2);
        activatTab($(this));
    });

    $( "#slide3" ).on( "click", function() {

        $('.carousel').carousel(3);
        activatTab($(this));
    });

    $( "#slide4" ).on( "click", function() {

        $('.carousel').carousel(4);
        activatTab($(this));
    });
});

function activatTab(tab){
    $('.tag').removeClass('active-tab-slide');
    tab.addClass('active-tab-slide');
}