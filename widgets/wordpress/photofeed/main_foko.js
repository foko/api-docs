$ = jQuery.noConflict();

$(document).ready(function() {
    var phpData = passedData;

    var $container = $('#photo_wrapper').masonry();
    $('#photo_wrapper').hide();
    $('#loading').html('<span><i class="fa fa-spinner fa-spin fa-4x" id="foko_photo_wrapper_spinner"></i><p>Loading your photo feeds...</p></span>');
    $container.imagesLoaded('always', function(instance) {
        $('#loading').remove();
        $('#photo_wrapper').show();
        $container.masonry({
            itemSelector: '.foko_item'
        });

    });

    $('body').prepend('<div class="image-link-overlay" id="image-link-overlay"><span class="center_helper"></span>');
    $('.image-link-overlay').append('<div class="photo-link-wrapper">' +
        '<div class="photo-link-container"><span class="center_helper"></span>' +
        '<div class="prev"><a id="foko-prev-link" href="#"><i class="fa fa-chevron-left fa-2x" id="foko-changePic-icon"></i></a></div>' +
        '<div class="imgHolder"><span class="center_helper"></span><img id="popupImage" src=""></div>' +
        '<div class="next"><a id="foko-next-link" href="#"><i class="fa fa-chevron-right fa-2x" id="foko-changePic-icon"></i></a></div>' +
        '<div class="full-description"><p><p/></div></div></div></div>');



    // $(".mask").click(function() {
    //     $(".image-link-overlay").toggle();
    //     var imageIndex = $(this).find("a").attr('alt');
    //     $('#popupImage').replaceWith('<img id="popupImage" src="' + phpData[1][imageIndex] + '" alt="' + imageIndex + '">');
    //     $('.full-description').replaceWith('<div class="full-description"><p><p/></div>');
    //     var tmpImg = new Image();
    //     tmpImg.src = phpData[1][imageIndex];
    //     tmpImg.onload = function() {

    //         $('.full-description').replaceWith('<div class="full-description"><p>' + phpData[4][imageIndex] + '<p/></div>');
    //     }
    // });

    $(".third-effect").click(function() {
        if (!($.browser.msie && $.browser.version < 9.0)) {
            $(this).parent().removeAttr('href');
            $(this).parent().removeAttr('target');
        }

        $(".image-link-overlay").toggle();
        var imageIndex = $(this).find('img').attr('alt');
        $('#popupImage').replaceWith('<img id="popupImage" src="' + phpData[1][imageIndex] + '" alt="' + imageIndex + '">');
        $('.full-description').replaceWith('<div class="full-description"><p><p/></div>');
        var tmpImg = new Image();
        tmpImg.src = phpData[1][imageIndex];
        tmpImg.onload = function() {

            $('.full-description').replaceWith('<div class="full-description"><p>' + phpData[4][imageIndex] + '<p/></div>');
        }
    });

    $(".image-link-overlay").click(function() {
        $(".image-link-overlay").toggle();
    }).children().click(function(e) {
        return false;
    });
    $(".photo-link-wrapper").click(function() {
        $(".image-link-overlay").toggle();
    }).children().click(function(e) {
        return false;
    });
    $("#foko-prev-link").click(function() {
        var imageIndex = $(this).parent().parent().find("img").attr('alt');
        if (imageIndex == 0) {
            imageIndex = phpData[1].length - 1;
        } else {
            imageIndex--;
        }
        $('#popupImage').replaceWith('<img id="popupImage" src="' + phpData[1][imageIndex] + '" alt="' + imageIndex + '">');
        $('.full-description').replaceWith('<div class="full-description"><p><p/></div>');
        var tmpImg = new Image();
        tmpImg.src = phpData[1][imageIndex];
        tmpImg.onload = function() {
            $('.full-description').replaceWith('<div class="full-description"><p>' + phpData[4][imageIndex] + '<p/></div>');
        }
    });
    $("#foko-next-link").click(function() {
        var imageIndex = $(this).parent().parent().find("img").attr('alt');
        if (imageIndex == phpData[1].length - 1) {
            imageIndex = 0;
        } else {
            imageIndex++;
        }
        $('#popupImage').replaceWith('<img id="popupImage" src="' + phpData[1][imageIndex] + '" alt="' + imageIndex + '">');
        $('.full-description').replaceWith('<div class="full-description"><p><p/></div>');
        var tmpImg = new Image();
        tmpImg.src = phpData[1][imageIndex];
        tmpImg.onload = function() {
            $('.full-description').replaceWith('<div class="full-description"><p>' + phpData[4][imageIndex] + '<p/></div>');
        }
    });
});