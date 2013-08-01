$(function(){
    $('.comment-textarea').each(function(index) {
        addConmmentInputHandler($(this));
    });
    
    $('.children_comment_textarea').hide();
    $('.reply_comment').click(function(){
         com = $(this).attr('comment_id');
         $('.id_'+com).slideToggle();
         $('.id_'+com).focus();
    });
    $('.children_comment_textarea').each(function(index) {
        addReplyCommmentInputHandler($(this));
    });
});

function addReplyCommmentInputHandler(dom) {
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
            content = $(this).val();
            poll_id = $(this).attr('data-poll-id');
            parent_id = $(this).attr('parent_comment');
            addReplyComment(poll_id, content, parent_id);
            $('.children_comment_textarea').val('');
       }
    });
}

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

function addReplyComment(poll_id, content, parent_id) {
    var url = 'index.php?r=comment/addreply';
        $.ajax({
        type: 'POST',
        url: url,
        data: {
            comment_data: {
                content: content,
                poll_id: poll_id,
                parent_id: parent_id,
            }
        }
    }).success(function(msg) {
        var arr = jQuery.parseJSON(msg);
        var tmp = new HtmlElement('reply', arr);
            tmp.appendTo('.children_'+parent_id);
    }).fail(function() {
        alert('Fail!');
    });
}

function addNewComment(data){
    if (data.parent_comment_id === null) {
        data.class_name = "comment";
        var tmp = new HtmlElement('live_comment', data);
        tmp.appendTo('.comment_area');
    } else {
        data.class_name = "comment_children";
        var tmp = new HtmlElement('live_comment', data);
        tmp.appendTo('.children_' + data.parent_comment_id);
    }
}