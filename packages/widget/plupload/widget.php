<?php namespace application\widget\plupload;  
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $options; 
 	public $url;
 	public $field='field';//字段名
 	public $values;//image values
 	public $ext = '*';
 	public $max_file_size = '100mb';
 	public $info = 'add files...';
	function run(){  
		$base = publish(__DIR__.'/assets'); 
 		js_file($base.'/browserplus-min.js'); 
 		js_file($base.'/plupload.full.js'); 
 		$this->url = url('file/site/upload');
 		$container = 'c_'.md5(uniqid()).mt_rand(0,900000);
 		$filelist = 'f_'.md5(uniqid()).mt_rand(0,900000);
 		$pickfiles = 'p_'.md5(uniqid()).mt_rand(0,900000);
 		js("
 			var uploader_".md5($this->field)." = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : '".$pickfiles."',
		container : '".$container."',
		multipart_params:{field:'".$this->field."'},
		max_file_size : '".$this->max_file_size."',
		url : '".$this->url."',
		flash_swf_url : '".$base."/plupload.flash.swf',
		silverlight_xap_url : '".$base."plupload.silverlight.xap',
		filters : [
			{title : \"".__('choice file')."\", extensions : \"".$this->ext."\"} 
		],
	 
	});

 

	$('#uploadfiles').click(function(e) {
		uploader_".md5($this->field).".start();
		e.preventDefault();
	});

	uploader_".md5($this->field).".init();

	uploader_".md5($this->field).".bind('FilesAdded', function(up, files) {
		$.each(files, function(i, file) {
			$('#".$filelist."').append(
				'<div id=\"' + file.id + '\">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'</div>');
			uploader_".md5($this->field).".start();  
		});

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader_".md5($this->field).".bind('UploadProgress', function(up, file) {
		$('#' + file.id + \" b\").html(file.percent + \"%\");
	});

	uploader_".md5($this->field).".bind('Error', function(up, err) {
		$('#".$filelist."').append(\"<div>Error: \" + err.code +
			\", Message: \" + err.message +
			(err.file ? \", File: \" + err.file.name : \"\") +
			\"</div>\"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});
	uploader_".md5($this->field).".bind('FileUploaded', function(up, file,data) {  
		data = eval(data);
		data = data.response;  
	 	$('#".$filelist."').append(data); 
		$('#' + file.id + \" \").html(\"\");
		plupload_after_".md5($this->field)."();
	});
	plupload_after_".md5($this->field)."();
	function plupload_after_".md5($this->field)."(){
		$('#".$container." .file .icon-remove').click(function(){
			$(this).parent('div.file:first').remove();
		});
		
		$( '#".$filelist."' ).sortable();
    }
 		");
 		echo $this->render('@application/widget/plupload/views/index',array(
 			'container'=>$container,
 			'filelist'=>$filelist,
 			'field'=>$this->field,
 			'values'=>$this->values,
 			'pickfiles'=>$pickfiles,
 			'info'=>$this->info
 		));
 	 
	}
}