## MinCMS  2.0.1 Beta 1
   
## Technology
* [Yii 2](http://github.com/yiisoft/yii2)
* [BootStrap 3](http://getbootstrap.com/)
* [Composer](http://getcomposer.org) 
 
## REQUIREMENTS
* PHP_VERSION 5.3.11 +
* MCrypt, GD, Reflection, PCRE, SPL, MBString, Intl  extends
* Apache Rewrite 

## install   

```
php composer.phar install   
```
### vhosts config
httpd-vhosts `yourdomain` is your custom domain
```
<VirtualHost *:80>
    ServerAdmin your@your-email.address
    DocumentRoot "/your-path/mincms/app/public"
    ServerName yourdomain
    ErrorLog "logs/mincms-error.log"
    CustomLog "logs/mincms.log" common
</VirtualHost>
```
Notice `mincms/app/public` is webroot
visite `http://yourdomain` it will show default page. there is install link.if your didn't installed mincms before.
backend link `http://yourdomain/admin` 

 

## MinCMS Content Manage System Functions
* packages is for comm application.such as modules,widget ,config and so on.
* there is a Composer install under packages dir. so you need `Composer install`
* auth module support access for user groups.
* email module support send mailer to some one
* content module ,this is very powerful module.it is easy create many kinds of contents.
* imageache module ,real cool module ,it it easy set image effect such as resize crop and so on
* for more great functions. install it. lol :) 

## Documents
   On dev......

### model show lists
controller:
```
public function actionIndex()
{    
	$rt = \application\core\Pagination::run('\application\modules\auth\models\User');   
	return $this->render('index', array(
	   'models' => $rt->models,
	   'pages' => $rt->pages,
	));
}
public function actionDelete($id){
	if($_POST['action']==1){ 
		$model = \application\modules\auth\models\User::find($id); 
		$model->delete();
		echo json_encode(array('id'=>array($id),'class'=>'alert-success','message'=>__('delete user success')));
		exit;
	} 
}
```

view:

``` 
<?php echo application\core\widget\Table::widget(array(
	'models'=>$models,
	'pages'=>$pages,
	'modal'=>true,
	'title'=>__('remove template'),
	'content'=>'do you want to do this',
	'fields'=>array('slug','memo')	,
));?>
```


## Fair Licensing 
 
**MinCMS is free and released as open source software covered by the terms of the [GNU Public License](http://www.gnu.org/licenses/gpl-3.0.html) (GPL v3).** You may not use the software, documentation, and samples except in compliance with the license. If the terms and conditions of this license are too restrictive for your use, alternative licensing is available for a very reasonable fee.

If you feel that this software is one great weapon to have in your programming arsenal, it saves you a lot of time and money, use it for commercial gain or in your business organization, please consider making a donation to the project. A significant amount of time, effort, and money has been spent on this project. Your donations help keep this project alive and the development team motivated. Donors and sponsors get priority support (24-hour response time on business days).


## Connect US 
```
QQ group：40933125
Email: mincms@outlook.com
```
 


