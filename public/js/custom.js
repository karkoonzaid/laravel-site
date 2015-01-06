/**
 * Created by usama_000 on 9/23/2014.
 */
$('#eventsTab').on('mouseover', function () {
    $(this).click();
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
