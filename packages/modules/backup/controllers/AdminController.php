<?php namespace application\modules\backup\controllers; 
use application\core\DB; 
/**
* database backup
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class AdminController extends \application\core\AuthController
{ 
	public $path;
	public $bin;
	public $name;
	public $pwd;
	public $db_name;
	public $host;
	public $file;
	function init(){
		parent::init();
		$this->path = base_path().'../backup';
		if(!is_dir($this->path)) mkdir($this->path,0777,true);
		$row = DB::queryOne("SHOW VARIABLES LIKE '%basedir%'");
		foreach($row as $k=>$v){
			$k = strtolower($k);
			if($k=='value')
				$this->bin = $v.'/bin/';
		} 
		$dsn = \Yii::$app->db->dsn; 
		$n = explode(';',$dsn); 
		$this->host = substr( $n[0] ,strpos($dsn,'=')+1);   
		$this->db_name = substr( $dsn ,strrpos($dsn,'=') +1); 
		$this->name = \Yii::$app->db->username;
		$this->pwd = \Yii::$app->db->password;
	 	$dir = $this->path."/".$this->db_name."_";
		$this->file = $dir.date('Ymd-H-i-s',time()).'.sql'; 
	}
	
	public function actionIndex()
	{   
		$this->active = array('extend','backup.admin.index');
		$list = scandir($this->path);
		foreach($list as $vo){
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{
				$rows[$vo]=filemtime($this->path.'/'.$vo);
			}
		}
		if($rows)
			$rows = array_reverse($rows);
		
	 	$data['rows'] = $rows;
	 	$data['dir'] = $this->path;
	 	return $this->render('index',$data);
	}
	
 	public function actionDo($id){
 		switch($id){ 
 			case 'store':
				$sql = $this->bin."mysqldump -h ".$this->host." -u".$this->name." -p".$this->pwd." ".$this->db_name." >  ".$this->file; 
				$msg = __("backup database ".$this->db_name." success");
				break;
				
			case 'restore':
				$sql = $this->bin."mysql -h ".$this->host." -u".$this->name." -p".$this->pwd." ".$this->db_name." <  ".$this->file; 
				$msg = __("return database ".$this->db_name." success");
 				break;
		}
		
		if(@exec($sql)){
			
		}
		flash('success',$msg);
		$this->redirect(url('backup/admin/index'));
 	}

	 
}
