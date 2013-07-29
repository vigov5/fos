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
            comment = $('.comment-textarea').val();
            addComment(comment, 1, 1);
            $('.comment-textarea').val("");
       }
    });   
}

function addComment(content, user_id, poll_id) {
    var url = 'index.php?r=comment/create';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            comment_data: {
                content: content,
                user_id: user_id,
                poll_id: poll_id
            }
        }
    }).success(function(id) {
        var comment_id = jQuery.parseJSON(id);
        var tmp = toHtml(content, user_id);
        $('.comment_area').append(tmp);
    }).fail(function() {
        alert('Fail!');
    });
}

function toHtml(content, user_id) {
    return "<div class='comment'>" +
            "<a href='#'>"+user_id+"</a>"+
            content + "<br/></div>";
}