var s_key = 83;
var enter_key = 13;
$(window).keydown(function(event) {  
  if ((event.which == s_key && (event.metaKey || event.ctrlKey))){
      $('#search').select();
      event.preventDefault();
  }
});

$(function() {
    $('#search').keypress(function(event){
        if (event.which == enter_key) {
            var key_word = $(this).val();
            event.preventDefault();
            searchResults(key_word);
        }
    });
});

function searchResults(key_word) {
    var url = window.location.protocol + '//' + window.location.host + window.location.pathname + '?r=search&key_word=' + key_word;
    window.location = url;
}