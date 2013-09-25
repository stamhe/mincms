<div id='polyglotLanguageSwitcher' >
<form method='get' action="<?php echo \Yii::$app->request->getUrl();?>">	 
		<?php 
		unset($_GET['language']);
		if($_GET){ 
			foreach($_GET as $k=>$v){
				echo "<input type='hidden' name='".$k."' value='".$v."' >";
			}
		}
		?>
		<select id="polyglot-language-options"   >
      	  <?php $i18n = array(
      		'zh_cn'=>'简体中文',
      	  	'en_US'=>'US', 
      		);
      		foreach($i18n as $k=>$v){ 
      			css("
      				#".$k."{background-image:url('".$base."/images/flags/{$k}.png"."')}
      			");
      		?>
      	   <option  id="<?php echo $k;?>" value="<?php echo $k;?>" <?php if(language() == $k ){?> selected <?php }?>>
      	   		 <?php echo __($v);?>
      	   	</option>
      	  <?php }?>
      </select>
	      	
       
  </form>
</div>
 