<?php 
use application\core\DB;
if($rows){
foreach($rows as $row){ 
if($admin)
	$url = url('oauth/'.$row['slug'].'/index',array('admin'=>$admin));
else
	$url = url('oauth/'.$row['slug'].'/index');
if($admin_login)
	$url = url('oauth/'.$row['slug'].'/index',array('admin_login'=>1));
?>
	<?php if($row['slug']=='paypal'){
		$a = DB::one('oauth_config',array(
			'where'=>array('slug'=>'paypal','display'=>1)
		)); 
  
	?>
		<span id="myContainer"></span>
		<script src="https://www.paypalobjects.com/js/external/api.js"></script>
		<script>
		paypal.use( ["login"], function(login) {
		  login.render ({
		    "appid": "<?php echo $a['key1'];?>",
		    "scopes": "openid profile email",
		    "containerid": "myContainer",
		    "locale": "en-us",
		    "returnurl": "<?php echo host().url('oauth/paypal/return');?>"
		  });
		});
		</script>
		<?php }else{
			
			?>
			<a href="<?php echo $url;?>">
				<?php if(true === $img){?>
					<img title="<?php echo $row['name'];?>"  src="<?php echo $base;?>/<?php echo $row['slug'];?>.png" />
					
				<?php }else {?>
					<?php echo $row['name'];?>
				<?php }?>
			</a> 
		<?php }?>
<?php }}?>