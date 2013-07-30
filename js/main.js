$(function() {
    checkWindowWidth();
    $(window).resize(function() {
        checkWindowWidth();
    });
    notificationDropDown();
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

function notificationDropDown() {
    loading_image = new HtmlElement('loading', {id: 'notification'});
    $('.notification-menu').CreateBubblePopup({         
        innerHtml: '<img id="loading-notification" src="images/ajax-loader-circle.gif">',
        themeName: 'blue',
        themePath: 'images/jquerybubblepopup-themes',
        selectable: true,
        divStyle: {
            'margin-top': '5px'
        },
        align : 'center',
        manageMouseEvents: false
    });
    $('.notification-menu').click(function(){
        if ($(this).IsBubblePopupOpen()) {
            $(this).HideBubblePopup();
        } else {
            $(this).ShowBubblePopup();
        }
    });     
}