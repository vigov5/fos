function countDown(start, end) {
	var note = $('#note'),
		ts,
        header = "",
        now = new Date().getTime(),
        max = 100 * 24 * 60 * 60 * 1000;

    if (now < start) {
        ts = new Date(start);
        header = "This poll will start in ";
    } else if (now < end) {
        ts = new Date(end);
        header = "This poll will end in ";
    } else {
        ts = -1;
    }
    if ((now < start && start - now < max) ||
            (now < end && end - now < max) || ts === -1) {
        $('#countdown').countdown({
            timestamp	: ts,
            callback	: function(days, hours, minutes, seconds){
                if (days === 0 && hours === 0 && minutes === 0 && seconds === 0 && ts !== -1){
                    location.reload();
                }
                var message = "";
                if (ts !== -1) {
                    message += header;
                    message += days + " day" + ( days===1 ? '':'s' ) + ", ";
                    message += hours + " hour" + ( hours===1 ? '':'s' ) + ", ";
                    message += minutes + " minute" + ( minutes===1 ? '':'s' ) + " and ";
                    message += seconds + " second" + ( seconds===1 ? '':'s' ) + ".";
                } else {
                    message = "This poll is end.";
                }
                note.html(message);
            }
        });
    }
}
