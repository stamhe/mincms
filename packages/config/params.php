<?php
$mongo_db = @include __DIR__.'/mongo_db.php';

$config = array(
	'adminEmail' => 'admin@example.com',
	'SecurityHelper'=>md5('SecurityHelper'), 
	'misc'=>array(),
);
if($mongo_db){
	$config = array_merge($mongo_db , $config);
}
return $config;