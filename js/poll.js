$(function(){
    $('.reply_comment').each(function(){
       addReplyListener($(this));
    });
    addCommmentInputHandler($('#comment-all'));
    addLoadMoreListener($('.load_more_button'));
});

function addLoadMoreListener(dom){
    dom.click(function(){
        var last_comment_id = $(this).attr('data-comment_id');
        loadMoreComment(last_comment_id);
    });
}

function loadMoreComment(last_comment_id){
    var url = 'index.php?r=comment/loadcomment';
    poll_id = $('#comment-all').attr('data-poll-id');
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            current_comment: last_comment_id,
            current_poll: poll_id,
        }
    }).success(function(msg) {
        var children_comments = jQuery.parseJSON(msg);
        $.each(children_comments, function(index, child) {
            var tmp = new HtmlElement('comment', child);
            tmp.appendTo('.comment_area');
            addReplyListener($('#reply_button_' + child.id));
        });
    }).fail(function() {
        alert('Fail!');
    });
}

function addReplyListener(dom){
    dom.click(function(){
        var comment_id = $(this).attr('data-comment_id');
        loadReplyComment(comment_id);
        var new_comment_input = new HtmlElement('new_comment_input', {id: comment_id});
        new_comment_input.appendTo('#comment_container_' + comment_id);
        addCommmentInputHandler($('#comment_input_' + comment_id), true);
    });
}

function loadReplyComment(comment_id) {
    var url = 'index.php?r=comment/getreplycomments'
    $.ajax({
        type: 'POST',
        url: url,
        data: {comment_id: comment_id}
    }).success(function(msg) {
        var children_comments = jQuery.parseJSON(msg);
        $.each(children_comments, function(index, child) {
            var tmp = new HtmlElement('reply', child);
            tmp.appendTo('#children_comments_' + comment_id);
        });
    }).fail(function() {
        alert('Fail!');
    });
}

function addCommmentInputHandler(dom, reply) {
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
            poll_id = $('#comment-all').attr('data-poll-id');
            parent_id = $(this).attr('data-parent_id');
            addComment(poll_id, content, parent_id, reply);
            $(this).val('');
       }
    });
}

function addComment(poll_id, content, parent_id, reply) {
    if (reply) {
        var url = 'index.php?r=comment/addreply';
    } else {
        var url = 'index.php?r=comment/create';
    }
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
        var new_comment = jQuery.parseJSON(msg);
        if (reply) {
            var tmp = new HtmlElement('reply', new_comment);
            tmp.appendTo('#children_comments_' + parent_id);
        } else {
            var tmp = new HtmlElement('comment', new_comment);
            tmp.prependTo('.comment_area');
            addReplyListener($('#reply_button_' + new_comment.id));
        }
    }).fail(function() {
        alert('Fail!');
    });
}

function addNewComment(data){
    console.log(data);
    data.content = data.comment_content;
    data.id = data.comment_id;
    if (data.parent_comment_id === null) {
        var tmp = new HtmlElement('comment', data);
        tmp.prependTo('.comment_area');
        addReplyListener($('#reply_button_' + data.id));
    } else {
        var tmp = new HtmlElement('reply', data);
        tmp.prependTo('#children_comments_' + data.parent_comment_id);
    }
}