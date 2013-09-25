<?php
use yii\helpers\Html;
use yii\widgets\Menu;  
 
?>
<?php $this->beginPage(); ?>  
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
 
	<?php $this->head(); ?>
 	
</head>

<body>
<?php $this->beginBody(); ?>  
	
<?php echo $content; ?> 
<?php $this->endBody(); ?>	
</body>
</html>	


<?php $this->endPage(); ?>
