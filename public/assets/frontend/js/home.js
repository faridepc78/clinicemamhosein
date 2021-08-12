$(function () {
    var expert = $('#home-expert');
    var expertList = $('#home-expert-list');

    expert.click(function () {
        if (expertList.css('display') == 'block') {
            $('#expert-tip').css('border-top-color', 'white');
        } else if (expertList.css('display') == 'none') {
            $('#expert-tip').css('border-top-color', 'red');
        }
        expertList.slideToggle();
    });

    var doctor = $('#home-doctor');
    var doctorList = $('#home-doctor-list');
    doctor.click(function () {
        if (doctorList.css('display') == 'block') {
            $('#doctor-tip').css('border-top-color', 'white');
        } else if (expertList.css('display') == 'none') {
            $('#doctor-tip').css('border-top-color', 'red');
        }
        doctorList.slideToggle();
    });

});


$(document).mouseup(function (e) {

    var container = $(".home-item-list, #home-expert");

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('#Home').css('height', '720');
        $(".home-item-list").slideUp('slow');
        $('#expert-tip').css('border-top-color', 'white');
    }

    var container = $(".home-item-list, #home-doctor");

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $('#Home').css('height', '720');
        $(".home-item-list").slideUp('slow');
        $('#doctor-tip').css('border-top-color', 'white');

    }
});


$(function () {
    "use strict";

    /*-----------------------------------
     * ONE PAGE SCROLLING
     *-----------------------------------*/
    // Select all links with hashes
    $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').not('[data-toggle="tab"]').on('click', function (event) {
        // On-page links
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            // Figure out element to scroll to
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            // Does a scroll target exist?
            if (target.length) {
                // Only prevent default if animation is actually gonna happen
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 300);
            }
        }
    });

});


$(function () {
    $(".close-thik").click(function () {
        $('#Home').css('height', '580');
        $(".close-thik").parent().slideUp();
        $('#expert-tip').css('border-top-color', 'white');
        $('#doctor-tip').css('border-top-color', 'white');
    });
});
