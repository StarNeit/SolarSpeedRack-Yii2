$(function(){

    'use strict';

    var optimizeMainImage = function() {
        var brHeight = $(window).height();
        var otherBlocks = $('.nav-wrap').height() + $('.nav-wrap1').height() + $('.footer').height();
        var blockHeight = brHeight - otherBlocks - 10;
        $('.address-main').height(blockHeight);
        $('.address-form').css('padding-top', blockHeight - 500);
    };

    optimizeMainImage();
});

