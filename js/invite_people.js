$(function() {

    $('.btn-check').click(function() {
        if ($(this).attr('check') == '0')
        {
            $(this).removeClass('btn-info');
            $(this).addClass('btn-warning');
            $(this).attr('check', '1');
            addPeople($(this).attr('sender_id'), $(this).attr('receiver_id'), $(this).attr('poll_id'));
        } else {
            $(this).attr('check', '0');
            $(this).removeClass('btn-warning');
            $(this).addClass('btn-info');
            removePeople($(this).attr('sender_id'), $(this).attr('receiver_id'), $(this).attr('poll_id'));
        }

    });
});

function addPeople(sender_id, receiver_id, poll_id)
{
    var url = '?r=invite/addpeople';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            invite: {
                sender_id: sender_id,
                receiver_id: receiver_id,
                poll_id: poll_id
            }
        }
    }).success(function() {
    }).fail(function() {
        alert('Add peopel fail !');
    });
}

function removePeople(sender_id, receiver_id, poll_id)
{
    var url = '?r=invite/removepeople';

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            invite: {
                sender_id: sender_id,
                receiver_id: receiver_id,
                poll_id: poll_id
            }
        }
    }).success(function() {
    }).fail(function() {
        alert('Remove fail ! ');
    });
}