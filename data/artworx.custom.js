$(function() {
	var xForum = $('#pun_wrapper');
	$('html title').html( $('title',xForum).html() );
	$('#qjump',xForum).each(function() {
		var xQJump = $(this);
		xQJump.attr({
			'action': '?module=fluxbb&action=viewforum'
		}).find('input[type=\'submit\']').remove();
		xQJump.find('select').attr({
			onchange: "window.location=('?module=fluxbb&action=viewforum&id='+this.options[this.selectedIndex].value)"
		});
	});
	$('img',xForum).each( function() {
		var xSrc = $(this).attr('src');
		xSrc = xSrc.replace('?module=fluxbb','fluxbb');
		$(this).attr('src', xSrc);
	});
	$('h3.code').click( function() {
		var code = $(this).parent().find('code');
		code.attr('id','blah');
		SelectText(code.attr('id'));
	});
	$('h3.code').each( function() {
		$(this).append('<span class=\'code_select_all\'>Select All</span>');
	});
});
function SelectText(element) {
    var doc = document;
    var text = doc.getElementById(element);
	text.removeAttribute('id');    
    if (doc.body.createTextRange) { // ms
        var range = doc.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        var selection = window.getSelection();
        var range = doc.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);

    }
}