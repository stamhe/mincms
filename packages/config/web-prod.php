<?php   
/**
* load modules
* 加载模块
*/
\Yii::setAlias('@application' , __DIR__.'/../');
$modules = cache_pre('all_modules');  
//默认系统模块
$modules['core'] = 1;
$modules['auth'] = 1;
$modules['imagecache'] = 1;
$modules['file'] = 1;
$modules['route'] = 1; 

if($modules){
	$alia = 'application';
	$alias = cache_pre('all_modules_alias');
	foreach($modules as $k=>$v){
		if($alias && $alias[$k]){
			$alia = $alias[$k]; 
		}
		$module[$k] = array(
			 'class' => $alia.'\modules\\'.$k.'\Module'
	    );
	}
} 
$modules = $module;	  
$route = cache_pre('route')?:array();
$default_route = array(
	'admin'=>'core/site/index', 
	'login'=>'auth/open/login',
	'pforgot'=>'auth/open/forgot',
	'preset'=>'auth/open/reset',
	'core'=>'core/config/index',
	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
); 
$routes = array_merge( $route , $default_route);    
$main =  array(
	'id' => 'hello',
	'timeZone'=>'Asia/Shanghai',
	'language'=>'zh_cn', 
	'basePath' => dirname(__DIR__),
	'preload' => array('log'), 
	'modules' => $module,
	'components' => array(  
		'cache' => array(
			'class' => 'yii\caching\FileCache', 
		),  
		/*'log' => array(
			'targets' => array(
				array(
					'class' => 'yii\log\FileTarget',
					'levels' => array('error', 'warning'),
				),
			),
		), */
		/**
		*
		*/  
		'urlManager' => array(
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl'=>true,
			'showScriptName'=>false,
			//'suffix'=>'.html',
			'rules'=>$routes,  
		), 
		'user' => array(
			'class' => 'yii\web\User',  
			'autoRenewCookie'=>false,
			'identityCookie'=>array('name' => 'admin_identity', 'httponly' => true),
			'identityClass' => 'application\modules\auth\models\User',
			'authTimeout'=>time()+15*60
		),
		'view' => array( 
			'class' => 'application\core\View',  
            'theme' => array(
            	'class' => 'application\core\Theme' 
		    ), 
        ),
        'assetManager'=>array(
	        'bundles' => array(
			    'yii\web\JqueryAsset' => array(
			        'sourcePath' => null,
			        'js' => array(
			             '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js',
			        ),
			    ),
			)
		)
			
	),
	'params' => require(__DIR__ . '/params.php'),
);
if (YII_DEBUG) {
//	$main['preload'][] = 'debug';
	$main['modules']['debug'] = 'yii\debug\Module';
	$main['modules']['gii'] = 'yii\gii\Module';
}
	
return $main;