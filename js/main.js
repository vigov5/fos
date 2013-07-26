$(function() {
    checkWindowWidth();
    $(window).resize(function() {
        checkWindowWidth();
    });
});

function checkWindowWidth() {
    var width = $(window).width();
    if (width < 1100) {
        $('#main-content').width('100%');
        $('#stream').hide();
    } else {
        $('#main-content').width('75%');
        $('#stream').show();
    }
}