<?php namespace application\core;  
use application\core\Arr;
/**
*  Menu菜单
* <?php $this->widget(Menu::className(), array(
				'options' => array('class' => 'nav '),
				'activateParents'=>true,
				'submenuTemplate'=>'<ul class="dropdown-menu">{items}</ul>',
				'items' => application\core\Menu::get(),
			)); ?>
* @author Sun < mincms@outlook.com >
*/
class Menu
{ 
	static function admin(){
		if(module_exists('content')){
			$all = \application\modules\content\Classes::cck_list(); 
		}
	    $active = \application\core\Menu::active(); 
	    $i = 0;
	    $it['label'] = __('content manage');
	    $it['url'] = '#';
	    $it['template'] = "<a href=\"{url}\" data-toggle='dropdown' class='dropdown-toggle'>{label}</a>";
	    $it['options'] = array(
	        'class' => 'dropdown', 
	    );
	    $flag = false;
	    if($all){
		    foreach($all as $vo){ 
				$it['items'][$i]['url'] = url('content/node/index',array('name'=>$vo['slug']));
				$it['items'][$i]['label'] = __($vo['name']);
				if($active && in_array('content/node/cck/'.$vo['slug'] , $active)){
					$it['items'][$i]['options']['class']='active';
					$it['options'] = array(
				        'class' => 'active'
				    );	
				}
				$i++;
			}	
			$flag = true;
		}	    	
		$menus = \application\core\Menu::get(); 
		if($flag === true)
			$menus['cck_content'] = $it;
		return $menus;
	}
	/**
	* show page title
	*/
	static function title(){
		if(property_exists(\Yii::$app->controller,'title')){
			return \Yii::$app->controller->title;
		}
	}
	static function active(){
		if(property_exists(\Yii::$app->controller,'active')){
			$active = \Yii::$app->controller->active;
			if(!is_array($active)) $active = array($active);
			if($active){
				foreach($active as $v){
					$v = str_replace('.','/',$v);
					if(strpos($v,'.')!==false)
						$ac[] = url($v);
					else
						$ac[] = $v;
				}
			}
			$active = $ac;
	 	}
	 	return $active;
	}
	/**
	*
	use yii\widgets\Menu;
	$action = \Yii::$app->controller->full_action;
	$menu = array(
		'cart list'=>array('cart/admin/index'),  
		'cart area'=>array('area/admin/index'), 
		'cart discount'=>array('cart/admin/discount'), 
		'cart email notice'=>array('cart/admin/notice'), 
		'cart set'=>array('cart/admin/set'), 
	);

	echo Menu::widget(array(
			'options' => array('class' => 'nav '), 
			'activateParents'=>true, 
			'items' => \application\core\Menu::next($menu,$action=='cart.admin.index'?true:false),
		));
	*/
	static function next($menus,$flag = true){ 
		if(property_exists(\Yii::$app->controller,'active')){
			$active = \Yii::$app->controller->active;
			if(!is_array($active)) $active = array($active);
			if($active){
				foreach($active as $v){
					$v = str_replace('.','/',$v);
					if(strpos($v,'.')!==false)
						$ac[] = url($v);
					else
						$ac[] = $v;
				}
			}
			$active = $ac;
	 	}  
	 	$i=0;
		foreach($menus as $key=>$val){ 
			unset($actived);  
			if(in_array($val[0],$active)){
				$actived = 'active';
			}     
			if($i==0 && $flag===false) $actived = '';
			$menu[$key] = array('label' => __($key), 'url' =>$val,'options'=>array(
					'class'=>"$actived",  
				), 
			);
			$i++; 
		} 
		return $menu;
	} 
	/**
	* 生成后台导航菜单
	*/
	static function get(){   
		/**
		* 控制器中可设置当前启用的URL
		$this->active = array('system','i18n.site.index');
		*/
		if(property_exists(\Yii::$app->controller,'active')){
			$active = \Yii::$app->controller->active;
			if(!is_array($active)) $active = array($active);
			if($active){
				foreach($active as $v){
					$v = str_replace('.','/',$v);
					if(strpos($v,'.')!==false)
						$ac[] = url($v);
					else
						$ac[] = $v;
				}
			}
			$active = $ac;
	 	}
		$modules = cache_pre('all_modules');  
		$alias = cache_pre('all_modules_alias'); 
		$_access = \Yii::$app->controller->_access;	 
		if($modules){
			foreach($modules as $k=>$v){
				$alia = $alias[$k];
				if(!$alia) continue;
				$file = \Yii::getAlias("@".$alia."/modules/{$k}/Menu.php");
			 
				if(file_exists($file)){
					
					$cls = "\\".$alia."\modules\\".$k."\Menu"; 
					$menus = $cls::add(); 
					
					
					foreach($menus as $key=>$val){
						if(!$menu[$key]){
							unset($actived); 
							if(Arr::array_in_array($key,$active)){
								$actived = 'active';
							}    
							$menu[$key] = array('label' => __($key), 'url' =>'#','options'=>array(
									'class'=>"dropdown $actived",  
								),
								'template'=>"<a href=\"{url}\" data-toggle='dropdown' class='dropdown-toggle'>{label}</a>",
							);
						}
						foreach($val as $_k=>$_u){
							//判断菜单是否显示
							$c = str_replace('/','.',$_u[0]);
							if( ( !$_access || !in_array($c,$_access) ) && uid()!=1 ) continue;
							
						 	unset($actived); 
							if(Arr::array_in_array($_u,$active)){
								$actived = 'active';
							}  
							
							if(substr($_u[0] , 0 ,1) != '/')
								$_u[0] = '/'.$_u[0];
							$menu[$key]['items'][] = array('label' => __($_k), 'url' => ($_u),'options'=>array(
								'class'=>$actived,
							));
						}
					}
				}
			}
		}  
	     
		return $menu;
		 
	}
}