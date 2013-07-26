$(function(){
    $('#add_choice').click(function(){        
        addChoice();                                
    });
    
    $('#add_choice_textfield').keypress(function(event){
        if (event.which === 13) {           
            addChoice();                                            
        }
    });
    
    addCloseListener();
    checkNumberChoices();
});

function addChoice() {
    var poll_id = $('#add_choice_textfield').attr('data-poll_id');
    var choice_content = $('#add_choice_textfield').val();
    if (choice_content === '') {
        return;
    } 
    var url = 'index.php?r=choice/create';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            poll_id: poll_id,
            content_choice: choice_content
        }
    }).success(function(msg) {
        var choice_id = jQuery.parseJSON(msg);
        var choice_html = createChoiceElement(choice_content, choice_id);        
        choice_html.appendTo('#choice_content');        
        HtmlElement.reset('#add_choice_textfield');
        addCloseListener(choice_id);
        checkNumberChoices();
    }).fail(function() {
        alert('Fail!');
    });
}

function deleteChoice(choice_id) {
    var url = 'index.php?r=choice/delete';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            choice_id: choice_id
        }
    }).success(function() {                
        HtmlElement.remove('#choice_' + choice_id, checkNumberChoices);         
    }).fail(function() {
        alert('Fail!');
    });
}

function addCloseListener (choice_id){
    if (choice_id === undefined) {
        $('.close_choice').click(function(){
            var choice_id = $(this).attr('data-choice_id');
            deleteChoice(choice_id);
        });
    } else {
        $('button[data-choice_id="' + choice_id + '"]').click(function(){
            var choice_id = $(this).attr('data-choice_id');
            deleteChoice(choice_id);
        });
    }
}

function createChoiceElement(choice_content, choice_id){
    var data = {
        id: 'choice_' + choice_id,
        choice_id: choice_id,
        choice_content: choice_content
    };
    return new HtmlElement('choice', data);        
};

function checkNumberChoices(){
    var count_div = $('#choice_content div').size();
    if (count_div > 9) {
        $('#add_choice_textfield, #add_choice').attr('disabled', 'disabled');
    } else {
        $('#add_choice_textfield, #add_choice').removeAttr('disabled');
    }
};
