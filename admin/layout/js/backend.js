$(function () {
    'use strict'

    // hide

    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));
        
        $(this).attr('placeholder', '');
    
    }).blur(function() {
        
        $(this).attr('placeholder', $(this).attr('data-text'));
    
    });

    $('.confirm').click(function () {
        return confirm("Are You Sure?");
    })
});