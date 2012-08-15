
$(document).ready(function(){
$('body').append("<div id='ajaxstatus' style='position:absolute;top:100px;left:100px'><img src='./images/ajax-loader.gif'></div>");
$('#ajaxstatus').live('ajaxComplete',function() { $(this).hide() }).live('ajaxStart',function() { $(this).show() });
});
