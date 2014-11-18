$ = jQuery.noConflict();

$(document).ready(function() {
    var $container = $('#photo_wrapper').imagesLoaded(function() {
        $container.isotope({
            itemSelector: '.foko_item',
            layoutMode: 'masonry',
        });
    });

    $('body').prepend('<div class="image-link-overlay" id="image-link-overlay"><span class="center_helper"></span>');
    $('.image-link-overlay').append('<div class="photo-link-wrapper">' +
        '<div class="photo-link-container"><span class="center_helper"></span>' +
        '<div class="prev"><a id="foko-prev-link" href="#"><i class="fa fa-chevron-left fa-2x" id="foko-changePic-icon"></i></a></div>' +
        '<div class="imgHolder"><span class="center_helper"></span><img id="popupImage" src=""></div>' +
        '<div class="next"><a id="foko-next-link" href="#"><i class="fa fa-chevron-right fa-2x" id="foko-changePic-icon"></i></a></div>' +
        '<div class="full-description"><p><p/></div></div></div></div>');

    var phpData = passedData;

    $(".mask").click(function() {
        $(".image-link-overlay").toggle();
        var imageIndex = $(this).find("a").attr('alt');
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