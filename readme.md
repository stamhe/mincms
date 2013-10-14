## MinCMS  2.1 稳定版
   
## 技术使用
* [PHP框架 Yii 2](http://github.com/yiisoft/yii2)
* [BootStrap 3](http://getbootstrap.com/)
* [Composer](http://getcomposer.org) 
 
## 环境要求
* PHP版本 5.3.11 +
* 扩展 MCrypt, GD, Reflection, PCRE, SPL, MBString, Intl  extends
* Apache重复

### 安装
执行Composer安装依赖的包
```
php composer.phar install 
``` 
然后设置目录权限
```
chmod -R 777 app/protected/runtime/
chmod -R 777 app/public/assets/
```
apache httpd-vhosts 配置`yourdomain` 是你的域名
```
<VirtualHost *:80>
    ServerAdmin your@your-email.address
    DocumentRoot "/your-path/mincms/app/public"
    ServerName yourdomain
    ErrorLog "logs/mincms-error.log"
    CustomLog "logs/mincms.log" common
</VirtualHost>
```
注意 `mincms/app/public` 是网站根目录
请访问 `http://yourdomain` 将会有提示安装，安装成功后直接访问 `http://yourdomain/admin`  

## 授权
免费使用于任何目的，不限商用。无需注明来源MINCMS。

## [捐助我们](https://me.alipay.com/suenkang)
捐助将直接用于官方网站开发与MINCMS的开发与维护。 

## 联系我们
```
QQ群：40933125 
```
 


