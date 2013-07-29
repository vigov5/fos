$(function(){
    $('.comment-textarea').each(function(index) {        
        addConmmentInputHandler($(this));
    });    
});

function addConmmentInputHandler(dom) {
    dom.keydown(function(event){
        if (event.keyCode === 13 && event.shiftKey || event.keyCode === 8) {            
            var rows = 0;
            var text = dom.val();
            var text_lines = text.split("\n");
            if (event.keyCode === 13) {
                rows += text_lines.length + 1;
            } else if (text_lines.length > 1 && text_lines[text_lines.length - 1] === "") {
                rows += text_lines.length - 1;
            } else {
                return;
            }                 
            dom.attr('rows', rows);
       }
    });   
}