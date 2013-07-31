$(function() {
    $('#show_search').click(function() {
        if ($('#form_search').is(':hidden')) {
            $('#form_search').show(HIDE_TIME);
            $(this).val('Hide Search');
        } else {
            $('#form_search').hide(HIDE_TIME);
            $(this).val('Show Search');
        }
    });
});