$(function(){
    loadRecentNotification();
});

function loadRecentNotification(){
    var url = 'index.php?r=notification/getnotify';
    $.ajax({
        type: 'GET',
        url: url,
        data: {
            all: true
        }
    }).success(function(msg) {
        var all_notify = '';
        var packet = $.parseJSON(msg);
        if (packet.length) {
            $.each($.parseJSON(msg), function (index, notify) {
                var content = createNotificationContent(notify.activities);
                var data = {content: content};
                var notification_html = new HtmlElement('notification', data);
                notification_html.appendTo('#notification-list');
            });

        } else {
        }
    }).fail(function() {
    });
}

function isExistsProfile(needle, haystack){
    var found = false;
    for (i=0; i<haystack.length; i++) {
       if (haystack[i].profile_id == needle.profile_id) {
           return true;
       }
    }
    return false;
}

function link_to(label, link){
    return '<a href="' + link + '">' + label + '</a>';
}

function createProfileLink(activity){
    return link_to(activity.profile_name, 'index.php?r=profile/view&id=' + activity.profile_id);
}

function createPollLink(activity){
    return link_to(activity.poll_question, 'index.php?r=poll/view&id=' + activity.poll_id);
}

function createNotificationContent(data){
    var voters = [];
    var commenters = [];
    var inviter;
    var notify_txt = '';
    var activity;
    var total_cmt = 0;

    var activities = [];
    $.each(data, function(index, act) {
        activity = $.parseJSON(act);
        if (activity.type == VOTE || activity.type == RE_VOTE) {
            if (isExistsProfile(activity, voters) == false) {
                voters.push(activity);
            }
        } else if (activity.type == INVITE) {
            inviter = activity;
        } else if (activity.type == COMMENT || activity.type == REPLY_COMMENT){
            total_cmt++;
            if (!isExistsProfile(activity, commenters)) {
                commenters.push(activity);
            }
        }
    });

    if (voters.length == 1) {
        notify_txt += createProfileLink(voters[0]) + ' voted ';
    } else if (voters.length == 2) {
        notify_txt += createProfileLink(voters[0]) + ' and ' + createProfileLink(voters[1]) + ' voted ';
    } else if (voters.length > 2) {
        notify_txt += createProfileLink(voters[0]) + ' and ' + (voters.length-1) + ' others voted ';
    }
    if (voters.length && commenters.length) {
        notify_txt += ', ';
    }
    if (commenters.length == 1) {
        notify_txt += createProfileLink(commenters[0]) + ' wrote ' + total_cmt + (total_cmt > 1 ?' comments ':' comment ');
    } else if (commenters.length == 2) {
        notify_txt += createProfileLink(commenters[0]) + ' and ' + createProfileLink(commenters[1]) + ' wrote ' + total_cmt + ' comments ';
    } else if (commenters.length > 2) {
        notify_txt += createProfileLink(commenters[0]) + ' and ' + (commenters.length - 1) + ' wrote ' + total_cmt + ' comments ';
    }

    if (inviter) {
        notify_txt = createProfileLink(inviter) + ' has invited you to vote '
    }

    notify_txt += 'in your poll ' + createPollLink(activity) + ' at ' + activity.updated_at;
    return notify_txt;
}