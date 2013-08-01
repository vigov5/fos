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
    var minDateEnd = new Date();
    
    if (!startDateTextBox.attr('disabled')) {
        minDateEnd = new Date(startDateTextBox.val());
        maxDateStart = new Date(endDateTextBox.val());
    }

    startDateTextBox.datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: new Date(),
        maxDate: maxDateStart,
        onClose: function(dateText, inst) {
            if (endDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    endDateTextBox.datetimepicker('setDate', testStartDate);
            } else {
                endDateTextBox.val(startDateTextBox.val());
            }
        },
        onSelect: function(selectedDateTime) {
            var date = endDateTextBox.val();
            endDateTextBox.datetimepicker('option', 'minDate', startDateTextBox.datetimepicker('getDate'));
            endDateTextBox.val(date);
        },
    });

    endDateTextBox.datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        minDate: minDateEnd,
        onClose: function(dateText, inst) {
            if (startDateTextBox.val() != '') {
                var testStartDate = startDateTextBox.datetimepicker('getDate');
                var testEndDate = endDateTextBox.datetimepicker('getDate');
                if (testStartDate > testEndDate)
                    startDateTextBox.datetimepicker('setDate', testEndDate);
            } else {
                startDateTextBox.val(endDateTextBox.val());
            }
        },
        onSelect: function(selectedDateTime) {
            var date = startDateTextBox.val();
            startDateTextBox.datetimepicker('option', 'maxDate', endDateTextBox.datetimepicker('getDate'));
            startDateTextBox.val(date);
        },
    });
});
