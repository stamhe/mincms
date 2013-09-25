<?php
/**
 * @var yii\base\View $this
 */
use yii\helpers\Html;
$this->title = 'Module Auth';
 

$info = hook('backend_admin_page',$this);
 
?>
<blockquote>
	<h3>
		<?php echo __('modules infomation');?>
	</h3>
</blockquote>

<hr>
<?php if($info) echo implode(' ',$info);?>
 
