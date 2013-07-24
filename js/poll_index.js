$(function() {
    $('#show_search').click(function() {
        if ($('#form_search').is(':hidden')) {
            $('#form_search').show(HIDE_TIME);
        } else {
            $('#form_search').hide(HIDE_TIME);
        }
    });
});