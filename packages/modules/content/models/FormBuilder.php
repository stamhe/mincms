<?php 
namespace application\modules\content\models; 
use application\modules\content\models\NodeActiveRecord;
use application\modules\content\classes\Node;
use application\modules\content\Classes;
/**
* 
* @author Sun < mincms@outlook.com >
*/
class FormBuilder extends \yii\base\Widget
{ 
 	 public $model;
	 public $file; //file 
	 public $data; //file data araay
	 public $name; //content type name 
	 public $attrs;//fileds
	 public $nid; //node id
	 public $script;
	 public $message;
	 protected $hook;
 	 /**
 	 * $params $file yaml文件，文件在forms目录下。且文件不能有.连接
 	 * 如在froms目录下的目录如 admin/post.php  该值为admin.post
 	 * @params $nid node id,如有值说明是更新操作
 	 */
	 function __construct($name,$nid=null){ 
	 	$this->message = __('save success');
	 	$model = new NodeActiveRecord;
	 	$this->file  = $file; 
	 	$this->nid  = $nid; 
	 	$this->data = Classes::structure($name); 
		$this->name =  $name; 
		$this->model = $model;
		$model::$table = $this->name;
		$hooks = cache_pre('hooks');
		$this->hook = $hooks['cck_hook'][$name];  
	 }

	 function run(){
	  	
	 	if($this->nid>0){
	 		/**
	 		* 如果有nid,说明是更新
	 		* 需要先取出NODE的内容并赋值给model
	 		*/
	 		$row = Classes::_one($this->name,$this->nid);
	 		foreach($row as $k=>$v){
	 			$this->model->$k=$v;
	 		} 
	 		$this->model = $this->hook($this->model , 'afterFind');
	 	} 
	 	$data['model'] = $this->model;
	 	//设置字段验证规则
	 	$this->set_rules();
	 	 
	 	if($_POST && \Yii::$app->request->isAjax){
	 		//保存数据到数据库  
	 		$attrs_data = (object)array();
	 		foreach($this->attrs as $get){
	 			$attrs_data->$get = $_POST['NodeActiveRecord'][$get];
	 		}
			$attrs_data = $this->hook($attrs_data);
		
	 	 	Node::save_model($this->name,$this->model,$attrs_data,$this->nid);
	 	}  
	 	$data['nid'] = $this->nid; 
	 	$data['data'] = $this->data; 
	 	$data['message'] = $this->message; 
	 	$data['script'] = $this->script; 
	 	
	 	return $this->render('@application/modules/content/models/FormBuilderView',$data);
	 }
	 function hook($attrs_data,$type='beforeSave'){
	 	$hooks = cache_pre('hooks'); 
		$hook = $this->hook;
		if($hook){
			if($hook){
				if(is_array($hook)){
					foreach($hook as $k=>$h){
						if(method_exists($h , $type)){
							$attrs_data = $h::$type($attrs_data,$k);
						}
					}
				}else{
					if(method_exists($hook , $type)){ 
						$attrs_data = $hook::$type($attrs_data);
					}
				}
			}
		}
		return $attrs_data;
	 }
	 /**
	 * 设置验证规则
	 */
	 function set_rules(){
	  	$data = Node::set_rules($this->data);
	 
		$this->attrs = $data['attrs']; 
	 	/**
	 	* 验证规则赋值给Model中的ruels属性
	 	*/
		$this->model->rules = $data['rules']; 

	 }
	 static function widget(){
	 	
	 }

}