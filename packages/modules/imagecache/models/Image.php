<?php namespace application\modules\imagecache\models; 
use application\core\Arr;
 
class Image extends \application\core\ActiveRecord 
{ 
	public $type;
	public static function tableName()
    {
        return 'imagecache';
    } 
    function scenarios() {
		 return array( 
		 	'all' => array('slug','description','memo'), 
		 );
	}
	public function rules()
	{ 
		return array(
			array('slug', 'required'), 
			array('slug', 'unique'),   
			array('slug', 'match','pattern'=>'/^[a-z_]/', 'message'=>__('match')), 
		);
	} 
	function beforeSave($insert){
		parent::beforeSave($insert);
		$memo = $_POST['memo'];
		foreach($memo as $k=>$arr){ 
			if(Arr::null($arr)<1){ 
				unset($_POST['memo'][$k]);
			}
		}
		$memo = $_POST['memo']?:array();
		$memo['_type'] = $_POST['Image']['type'];  
		$this->memo = serialize($memo);  
		return true;
	}
	function afterSave($insert){
		parent::afterSave($insert);
		$arr = array($this->id,$this->slug);
		foreach($arr as $id){
			cache("table_imagecache_".$id,false); 
		}
	}
	function afterFind(){
		parent::afterFind();
		$this->memo = unserialize($this->memo);   
		$this->type = $this->memo['_type']; 
		foreach($this->memo as $k=>$v){
			if(!in_array($k,$this->type))
				unset($this->memo[$k]);
		}
	}
 
	 
	 
}