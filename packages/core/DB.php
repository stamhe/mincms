<?php namespace application\core;  
/** 
* 具体参数可参考
* https://github.com/yiisoft/yii2/blob/master/framework/yii/db/QueryBuilder.php
*
* @author Sun < mincms@outlook.com >
* @date 2013
*/
class DB{
	static function queryAll($sql){
		return static::queryRow($sql,true);
	}
	
	static function queryOne($sql){
		return static::queryRow($sql);
	}
	static function queryRow($sql,$flag=false){
		$command = \Yii::$app->db->createCommand($sql);
		if(false === $flag)
			return $command->queryOne();
		return $command->queryAll();
	}
	static function one($table,$getway=array()){
		$command = static::_query($table,$getway);
		return $command->queryOne(); 
	}
	static function all($table,$getway=array()){
		$command = static::_query($table,$getway); 
		return $command->queryAll();  
	}
	
	static function insert($table,$data=array()){ 
		return \Yii::$app->db->createCommand()
			->insert($table,$data)->execute();   	
	}
	static function batchInsert($table, $columns, $rows){ 
		return \Yii::$app->db->createCommand()
			->batchInsert($table, $columns, $rows)->execute();   	
	}
	static function id(){ 
		return \Yii::$app->db->getLastInsertID();
	}
	/**
	* the same as pagination
	*/
	static function pager($table,$params=array(),$config=array('pageSize'=>10),$route=null){
		return static::pagination($table,$params,$config,$route);
	}
	/**
	* DB pagination
	*
	* Example  
	* <code>
	*   $data = \application\core\DB::pagination('file');
	*	return $this->render('test',$data);
	*	foreach($models as $v){	
	*	}
	*	<div class='pagination'>
	*	<?php  echo \application\core\LinkPager::widget(array(
	*	      'pagination' => $pages,
	*	  ));?>
	*	</div>
	* </code>
	*/
	static function pagination($table,$params=array(),$config=array('pageSize'=>10),$route=null){
		if(!is_array($config)){
			$config=array('pageSize'=>$config);
		}
		$one = static::one($table,array(
			'select'=>'count(*) count'
		));
	 
		$config['totalCount'] = $one['count'];
		$pages = new \yii\data\Pagination($config); 
		if($route)
			$pages->route = $route;
		$params['offset'] = $pages->offset;
		$params['limit'] = $pages->limit; 
     	$models = static::all($table,$params);
     	return (object)array(
			'pages'=>$pages,
			'models'=>$models
		);
	}
	
	/**
	*  
	* 其中$condition
	```
	* array(
	* 	'id=:id',
	*		array( ':id'=>$node_id)
	* ))
	```
	*/
	static function update($table, $columns, $condition = '', $params = array()){ 
		return \Yii::$app->db->createCommand()
			->update($table,$columns,$condition,$params)->execute();   	
	}
	static function delete($table, $condition = '', $params = array()){ 
		return \Yii::$app->db->createCommand()
			->delete($table, $condition , $params)->execute();   		
	}
	static function query($sql){
		return \Yii::$app->db->createCommand($sql)->execute();
	}
	static function _query($table,$getway=array()){ 
		$query = new \yii\db\Query;
		$query = $query->from($table);
		if($getway){
			foreach ($getway as $key => $value) {
				$query = $query->$key($value); 
			}
		} 
		return $query->createCommand();  
	}
}