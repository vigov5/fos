$(function(){
    $('.comment-textarea').each(function(index) {
        addConmmentInputHandler($(this));
    });    
});

function addConmmentInputHandler(dom) {
    dom.keydown(function(event){
        if (event.keyCode === 13 && event.shiftKey || event.keyCode === 8) {            
            var rows = 0;
            var text = dom.val();
            var text_lines = text.split("\n");
            if (event.keyCode === 13) {
                rows += text_lines.length + 1;
            } else if (text_lines.length > 1 && text_lines[text_lines.length - 1] === "") {
                rows += text_lines.length - 1;
            } else {
                return;
            }                 
            dom.attr('rows', rows);
       }
       if(event.keyCode === 13 && !event.shiftKey) {
            content = $('.comment-textarea').val();
            poll_id = $('.comment-textarea').attr('data-poll-id');
            addComment(content, poll_id);
            $('.comment-textarea').val('');
       }
    });   
}

function addComment(content, poll_id) {
    var url = 'index.php?r=comment/create';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            comment_data: {
                content: content,
                poll_id: poll_id
            }
        }
    }).success(function(msg) {
        var arr = jQuery.parseJSON(msg);
        var tmp = new HtmlElement('comment', arr);
             tmp.appendTo('.comment_area');
    }).fail(function() {
        alert('Fail!');
    });
}
