$(function(){
    $('#add_choice').click(function(){
        var poll_id = $('#add_choice_textfield').attr('data-poll_id');
        var content_choice = $('#add_choice_textfield').val();
        add_choice(poll_id, content_choice);
    });
});

function add_choice(poll_id, content_choice) {
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?r=choice/create';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            poll_id: poll_id,
            content_choice: content_choice
        }
    }).success(function() {
        $('#choice_content').append(addHtml(content_choice));
        $('#add_choice_textfield').val('');
    }).fail(function() {
        alert('Fail!');
    });
}

function addHtml(content_choice){
    var html = '<div class="well well-small">';
    html += content_choice + '</div>';
    return html;
};