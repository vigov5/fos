var HIDE_TIME = 500;

var HtmlElement = function(element_name, data) {
    this.views_dir = 'js/views/';
    this.element_name = element_name;
    this.setElement(element_name);
    this.setData(data);    
    this.render();
};

HtmlElement.prototype.setElement = function(element_name) {
    this.element_name = element_name;
    this.view = this.views_dir + this.element_name + '.ejs';
};

HtmlElement.prototype.setData = function(data) {
    this.data = data;
    this.element_id = this.element_name + "_" + data.id;
};

HtmlElement.prototype.render = function() {        
    this.html = new EJS({url: this.view}).render(this.data);
    return this.html;
};

HtmlElement.prototype.appendTo = function(container) {
    $(container).append(this.html);
};

HtmlElement.prototype.prependTo = function(container) {
    $(container).prepend(this.html);
};

HtmlElement.prototype.toggleMe = function(callback) {
    $('#' + this.element_id).toggle(HIDE_TIME);
    if (callback !== undefined) {
        callback();
    }
};

HtmlElement.prototype.showMe = function(callback) {
    $('#' + this.element_id).slideDown(HIDE_TIME);
    if (callback !== undefined) {
        callback();
    }
};

HtmlElement.prototype.hideMe = function(callback) {
    $('#' + this.element_id).hide(HIDE_TIME);
    if (callback !== undefined) {
        callback();
    }
};

HtmlElement.show = function(element, callback) {
    $(element).show(HIDE_TIME);
    if (callback !== undefined) {
        callback();
    }
};

HtmlElement.hide = function(element, callback) {
    $(element).hide(HIDE_TIME);
    if (callback !== undefined) {
        callback();
    }
};

HtmlElement.remove = function(element, callback) {
    $(element).hide(HIDE_TIME, function(){
        $(element).remove();
        if (callback !== undefined) {
            callback();
        }
    });
};

HtmlElement.reset = function(element) {
    $(element).val('');
};