<?php
js("
$(function(){
	var url = $.url(); 
	var  code = url.fparam('code'); 
	window.location.href = '".url('oauth/wole/next')."?code='+code;
});
"); 
js_file(base_url().'js/jquery.url.js');
?>
 