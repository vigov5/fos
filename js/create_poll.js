$(function() {
    var list_option = new Array("select_multichoice", "poll_type", "display_type", 
        "result_display_type", "result_detail_type", "result_show_time_type");
    var select_multichoice = new Array("This Poll is not multichoices !", 
       "This Poll is multichoices !");
    var poll_type = new Array("", "Owner can't view and public voter name !", 
       "Owner can view and public voter name !");
    var display_type = new Array("", "All user can see and all user can vote !",
       "All user can see and invited user can vote!", "Invited user can see and invited user can vote!");
    var result_display_type = new Array("", "All user who can access can see result !", 
       "Only voted user can see result!", "Only owner can see result!");
    var result_detail_type = new Array("", "All result include who voted !", 
       "Show only percentage of each choice!");
    var result_show_time_type = new Array("", "Show result only after poll expired!", 
       "Show result during voting time!");

    $('.select_option').CreateBubblePopup({
         position: 'right',
         align: 'center',
         alwaysVisible: false,
         innerHtmlStyle: {
             color: '#FFFFFF',
             'text-align': 'center'
         },
         themeName: 'all-black',
         themePath: 'images/jquerybubblepopup-themes',
         mouseOut: 'show'
    });
    
    for (i=0; i<list_option.length; i++) {
        var arr = eval(list_option[i]);
        $('#' + list_option[i]).SetBubblePopupInnerHtml(arr[parseInt($('#' + list_option[i]).val())]);
    }
    $('.select_option').ShowAllBubblePopups();

    $('.select_option').change(function(){
        var id = $(this).attr('id');
        var arr = eval(id);
        $(this).SetBubblePopupInnerHtml(arr[parseInt($(this).val())]);
        $(this).ShowAllBubblePopups();
    });
    
    if ($('#poll_type').val() == 1) {
        $('#poll_type_content').html('Owner can\'t view and public voter name !').fadeIn();
        $('#result_detail_type').val(2);
        $('#result_detail_type_content').html('Show only percentage of each choice!').fadeIn();
        $('#result_detail_type').attr('disabled', 'true');
    }
    $('#poll_type').change(function() {
        var type = $(this).val();
        if (type == 1) {
            $("#result_detail_type").val(2);
            $('#result_detail_type').attr('disabled', 'true');
            $("#result_detail_type").SetBubblePopupInnerHtml(result_detail_type[parseInt($("#result_detail_type").val())]);
            $("#result_detail_type").ShowAllBubblePopups();
            $('#result_detail_type_content').html('Show only percentage of each choice!').fadeIn();
            $('#poll_type_content').html('Owner can\'t view and public voter name !').fadeIn();
        }
        else {
            $('#poll_type_content').html('Owner can view and public voter name !').fadeIn();
            $('#result_detail_type').removeAttr('disabled');
        }
    });

    $('#display_type').change(function() {
        var type = $(this).val();
        $('#display_type_content').fadeOut(function() {
            if (type == '1') {
                var html = 'All user can see and all user can vote!';
            }
            else if (type == '2') {
                var html = 'All user can see and invited user can vote!';
            }
            else {
                var html = 'Invited user can see and invited user can vote!';
            }
            $('#display_type_content').html(html).fadeIn();
        });
    });

    $('#result_display_type').change(function() {
        var type = $(this).val();
        $('#result_display_type_content').fadeOut(function() {
            if (type == '1') {
                var html = 'All user who can access can see result !';
            }
            else if (type == '2') {
                var html = 'Only voted user can see result!';
            }
            else {
                var html = 'Only owner can see result!';
            }
            $('#result_display_type_content').html(html).fadeIn();
        });
    });

    $('#result_detail_type').change(function() {
        var type = $(this).val();
        $('#result_detail_type_content').fadeOut(function() {
            if (type == '1') {
                var html = 'All result include who voted !';
            }
            else {
                var html = 'Show only percentage of each choice!';
            }
            $('#result_detail_type_content').html(html).fadeIn();
        });
    });

    $('#result_show_time_type').change(function() {
        var type = $(this).val();
        $('#result_show_time_type_content').fadeOut(function() {
            if (type == '0') {
                var html = 'Show result only after poll expired !';
            }
            else {
                var html = 'Show result during voting time !';
            }
            $('#result_show_time_type_content').html(html).fadeIn();
        });
    });
    
    var startDateTextBox = $('#start_at');
    var endDateTextBox = $('#end_at');
    
    var maxDateStart;
    var minDateStart = new Date();
    var minDateEnd = new Date(new Date().getTime() + 600000);
    
    if (!startDateTextBox.attr('disabled') && startDateTextBox.val() != '' && $('#start_at').attr('edit') == 1) {
        minDateEnd = new Date(new Date(startDateTextBox.val()).getTime() + 600000);
        maxDateStart = new Date(new Date(endDateTextBox.val()).getTime() - 600000);
    }

    startDateTextBox.datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: minDateStart,
        maxDate: maxDateStart,
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() == '') {
                startDateTextBox.datetimepicker('setDate', minDateStart);
                endDateTextBox.datetimepicker('setDate', minDateEnd);
            } else if (endDateTextBox.val() == '') {
                endDateTextBox.datetimepicker('setDate', new Date(new Date(startDateTextBox.val()).getTime() + 600000));
            } else {
                var testStartDate = new Date(startDateTextBox.val()).getTime();
                var testEndDate = new Date(endDateTextBox.val()).getTime();
                if (testStartDate + 600000 > testEndDate)
                    endDateTextBox.datetimepicker('setDate', new Date(new Date(startDateTextBox.val()).getTime() + 600000));
            }
        },
        onSelect: function(selectedDateTime) {
            if (!endDateTextBox.attr('disabled')) {
                var time = endDateTextBox.val();
                endDateTextBox.datetimepicker('option', 'minDate', new Date(new Date(startDateTextBox.val()).getTime() + 600000));
                endDateTextBox.datetimepicker('option', 'minDateTime', new Date(new Date(startDateTextBox.val()).getTime() + 600000));
                endDateTextBox.val(time);
            }
        },
    });

    endDateTextBox.datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: minDateEnd,
        minDateTime: minDateEnd,
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() == '') {
                startDateTextBox.datetimepicker('setDate', minDateStart);
                endDateTextBox.datetimepicker('setDate', minDateEnd);
            } else if (startDateTextBox.val() == '') {
                startDateTextBox.datetimepicker('setDate', new Date(new Date(endDateTextBox.val()).getTime() - 600000));
            } else {
                var testStartDate = new Date(startDateTextBox.val()).getTime();
                var testEndDate = new Date(endDateTextBox.val()).getTime();
                if (testStartDate + 600000 > testEndDate)
                    startDateTextBox.datetimepicker('setDate', new Date(new Date(endDateTextBox.val()).getTime() - 600000));
            }
        },
        onSelect: function(selectedDateTime) {
            if (!startDateTextBox.attr('disabled')) {
                var time = startDateTextBox.val();
                startDateTextBox.datetimepicker('option', 'maxDate', new Date(new Date(endDateTextBox.val()).getTime() - 600000));
                startDateTextBox.datetimepicker('option', 'maxDateTime', new Date(new Date(endDateTextBox.val()).getTime() - 600000));
                startDateTextBox.val(time);
            }
        },
    });
    
    var ONE_SECOND = 1000;
    var FIVE_SECOND = 5 * ONE_SECOND;
    var interval = setInterval(function(){
        var time = new Date();
        if (!startDateTextBox.attr('disabled') && new Date(startDateTextBox.val()).getTime() < time.getTime()) {
            startDateTextBox.datetimepicker('setDate', new Date(time.getTime()));
            if (new Date(endDateTextBox.val()).getTime() < time.getTime() + 600000) {
                endDateTextBox.datetimepicker('setDate', new Date(time.getTime() + 600000));
            }
        }
    }, ONE_SECOND);

    var timeStart = $('#start_at').val();
    var timeEnd = $('#end_at').val();
    if (startDateTextBox.val() != '' && $('#start_at').attr('edit') == 1) {
        var interval1 = setInterval(function(){
            if (new Date(timeStart).getTime() < new Date().getTime()) {
                $('#start_at').attr('disabled', 'disabled');
                clearInterval(interval1);
            }
        }, ONE_SECOND);
    }
    
    if (endDateTextBox.val() != '' && $('#end_at').attr('edit') == 1) {
        var interval2 = setInterval(function(){
            if (new Date(timeEnd).getTime() < new Date().getTime()) {
                $('#end_at').attr('disabled', 'disabled');
                clearInterval(interval2);
            }
        }, ONE_SECOND);
    }
});