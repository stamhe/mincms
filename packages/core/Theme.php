<?php namespace application\core;  
/** 
*  controller public $theme; change theme
'view' => array( 
    'theme' => array(
    	'class' => 'application\core\Theme',  
        'baseUrl' => '@web/themes/'.$theme,
    ),
    'renderers' => array( 
        'twig' => array(
            'class' => 'yii\renderers\TwigViewRenderer',
            'cachePath' => '@webroot/assets/runtime/Twig/cache',
        ), 
    ),
),
* @author Sun < mincms@outlook.com >
*/
class Theme extends \yii\base\Theme
{ 
	public function init()
	{ 
		if(!\Yii::$app->controller){
			 header('');  
			 
		}
	 
		$theme =\Yii::$app->controller->theme;
		$this->pathMap = array(
			'@app/views'=>'@webroot/themes/'.$theme.'/views'
		);
		$this->baseUrl = '@web/themes/'.$theme;
		$this->basePath = '@webroot/themes/'.$theme; 
	  
	 	parent::init(); 
	  
	}

}