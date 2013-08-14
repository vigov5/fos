$(function() {
    
    $('.btn').click(function() {
            $(this).hide();
            addPeople($(this).attr('sender_id'), $(this).attr('receiver_id'), $(this).attr('poll_id'));
    });
    
     $('#close-window').click(function() {
         window.close();
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
        alert('Fail to add people !');
    });
}