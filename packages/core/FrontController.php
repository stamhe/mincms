<?php namespace application\core;  
/**
* front controller
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class FrontController extends Controller
{  
	
	public $active;
	public $theme = 'app';
	function init(){
		parent::init();  
	 	hook('action_init_front',$this);   
	}  
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		hook('action_before_front',$this); 
		return true;
	}
	public function afterAction($action, &$result)
	{
		parent::afterAction($action, $result);
		hook('action_after_front',$this); 
		return true;
	}
 
}