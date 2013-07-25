/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @author Nguyen Trung Quan
 */
$(function(){
    $('#show_btn').click(function(){
        if ($('#profile_info').is(':hidden')) {
            $('#profile_info').show(HIDE_TIME);
            $('#show_btn').prop('value', 'Hide profile');
        } else {
            $('#profile_info').hide(HIDE_TIME);
            $('#show_btn').prop('value', 'Show profile');
        }
    });
})