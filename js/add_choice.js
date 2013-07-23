$(function(){
    $('#add_choice').click(function(){
        var poll_id = $('#add_choice_textfield').attr('data-poll_id');
        var content_choice = $('#add_choice_textfield').val();
        if (content_choice === '') {
            alert('Choice content not empty!');
        } else {
            addChoice(poll_id, content_choice);
        }
    });
    
    $('#add_choice_textfield').keypress(function(event){
        if (event.which === 13) {
            var poll_id = $('#add_choice_textfield').attr('data-poll_id');
            var content_choice = $('#add_choice_textfield').val();
            if (content_choice === '') {
                alert('Choice content not empty!');
            } else {
                addChoice(poll_id, content_choice);
            }
        }
    });
    
    addCloseListener();
});

function addChoice(poll_id, content_choice) {
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?r=choice/create';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            poll_id: poll_id,
            content_choice: content_choice
        }
    }).success(function(msg) {
        var choice_id = jQuery.parseJSON(msg);
        $('#choice_content').append(addHtml(content_choice, choice_id));
        $('#add_choice_textfield').val('');
        addCloseListener(choice_id);
    }).fail(function() {
        alert('Fail!');
    });
}

function deleteChoice(choice_id) {
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?r=choice/delete';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            choice_id: choice_id
        }
    }).success(function() {
        $('div[data-choice_id="' + choice_id + '"]').hide(window, 500);
    }).fail(function() {
        alert('Fail!');
    });
}

function addCloseListener (choice_id){
    if (choice_id === undefined) {
        $('.close_choice').click(function(){
            var choice_id = $(this).attr('data-choice_id');
            deleteChoice(choice_id);
        });
    } else {
        $('button[data-choice_id="' + choice_id + '"]').click(function(){
            var choice_id = $(this).attr('data-choice_id');
            deleteChoice(choice_id);
        });
    }
}

function addHtml(content_choice, choice_id){
    var html = '<div class="well well-small" data-choice_id="';
    html += choice_id + '">';
    html += content_choice + '<button class="close close_choice" data-choice_id="';
    html += choice_id + '">&times;</button></div>';
    return html;
};

