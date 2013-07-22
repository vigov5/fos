$(function(){
   $('#poll_type').change(function(){
       var type = $(this).val();
        $('#poll_type_content').fadeOut(function(){
            if (type != '1') {
                var html = 'Owner can view and public voter name !';
            }
             else {
                var html = 'Owner can not view and public voter name !';
            }
            $('#poll_type_content').html(html).fadeIn();
        });
   }); 

   $('#display_type').change(function(){
       var type = $(this).val();
       $('#display_type_content').fadeOut(function(){
            if (type == '0') {
                var html = 'All user can see and all user can vote!';
            }
             else if (type == '1') {
                var html = 'All user can see and invited user can vote!';
            }
            else {
                var html = 'Invited user can see and invited user can vote!'; 
            }
            $('#display_type_content').html(html).fadeIn();
        });
    }); 
 
   $('#result_display_type').change(function(){
       var type = $(this).val();
       $('#result_display_type_content').fadeOut(function(){
            if (type == '0') {
                var html = 'All user who can access can see result !';
            }
             else if (type == '1') {
                var html = 'Only voted user can see result!';
            }
            else {
                var html = 'Only owner can see result!'; 
            }
            $('#result_display_type_content').html(html).fadeIn();
        });
    }); 
  
  $('#result_detail_type').change(function(){
       var type = $(this).val();
        $('#result_detail_type_content').fadeOut(function(){
            if (type == '0') {
                var html = 'All result include who voted !';
            }
             else {
                var html = 'Show only percentage of each choice!';
            }
            $('#result_detail_type_content').html(html).fadeIn();
        });
   });
   
  $('#result_show_time_type').change(function(){
       var type = $(this).val();
        $('#result_show_time_type_content').fadeOut(function(){
            if (type == '0') {
                var html = 'Show result only after poll expired !';
            }
             else {
                var html = 'Show result during voting time !';
            }
            $('#result_show_time_type_content').html(html).fadeIn();
        });
   });
   
   $('.poll_time').datetimepicker({
       dateFormat: "yy-mm-dd"
   });
});
