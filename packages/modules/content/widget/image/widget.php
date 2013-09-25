<?php namespace application\modules\content\widget\image;  
use application\core\DB;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class Widget extends \application\modules\content\Widget
{  
	
  	static function content_type(){  
		return "<input type='hidden' name='Field[relate]' value='file'>";
	}
 	static function node_type(){  
		 return 'int';
	}
	function run(){  
		$name = $this->name;   
 		$id = "NodeActiveRecord[".$name."]"; 
 		if($this->value){  
 			$condition['where']  =  array(
				'id'=>$this->value
			);
 			if(is_array($this->value))
				$condition['orderBy']  = array('FIELD (`id`, '.implode(',',$this->value).')'=>''); 
			
 			$all = DB::all('file',$condition);  
 		}
 		$data['id'] = $id;
 		$data['all'] = $all;
 		$data['name'] = $name;
 		echo $this->render('@application/modules/content/widget/image/view',$data);	 
	}
}