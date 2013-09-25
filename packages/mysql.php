<?php
/**
* 数据库操作类
*/
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
global $app;   
$mysql = $app['db']['db'];   
if(!$mysql) return;
ini_set('date.timezone',$main['timeZone']?$main['timeZone']:'Asia/Shanghai');
if ( ! function_exists('pr'))
{
	function pr($str){
		print_r('<pre>');
		print_r($str);
		print_r('</pre>');
	}
}
 
if ( ! class_exists('db'))
{
	class db{
		protected $_conn;
		protected $_query;
		public $id;  
		function connect($dsn,$user,$pwd){
			try {
				$this->_conn = @new PDO($dsn,$user,$pwd,array(
					PDO::ATTR_PERSISTENT=>true
				));
				$this->id = true; 
			} catch (PDOException $e) { 
			    $this->id = false;
			}
		}
		function query($sql){
			$this->_query = $this->_conn->prepare($sql); 
			$this->_query->execute();
			return $this;
		}
		function one(){
			return $this->_query->fetch(PDO::FETCH_OBJ);
		}
		function all(){
			while($list = $this->_query->fetch(PDO::FETCH_OBJ)){
				$data[] = $list;
			}
			return $data;
		}
	} 
}
$app['_db'] = $db = new db;
$db->connect($mysql['dsn'],$mysql['username'],$mysql['password']); 
