<?php global $app;  
use yii\helpers\Markdown; 
 
 
$config = "../protected/config/database.php";
$f  = file_get_contents($config);
$flag = false;
if(strpos($f,'{dsn}')!==false){
	$flag = true;
} 
?>
 
<div class="bs-header" style="width:100%;">
  <div class="container">
   	 <h1 style="width:100%;">欢迎使用MINCMS</h1>
   	 支持多种模块，如 权限，邮件，自定义内容，多语言 等。
   	 <br>您可开发您所需要的模块
   	 主要给程序员使用 
   	<p>如果MINCMS切实对您有帮忙，<br>
   	您可考虑 <a href="https://me.alipay.com/suenkang" target='_blank'>捐助我们</a></p>
  </div>
</div>
<div class="container">
<?php  if(true === $flag){ 
?> 

<p class='alert alert-danger' style="width:100%;">
	请先安装 <a href="<?php echo url('install/index');?>" style="font:16px;">点击安装</a>
</p>
<?php }else{?>
	<p class='alert alert-success' style="width:100%;">
	已安装 <a href="<?php echo url('core/config/index');?>" target='_blank'>后台管理</a>	
	</p>
<?php }?>
</div>
	
 
