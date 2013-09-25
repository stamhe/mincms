```
use application\modules\email\Mailer; 
$title = 'test';
$body = "this is a test <a href='http://baidu.com'>BAIDU</a>";
$to = 'your@domain.com';
Mailer::send($title,$body,$to,$attachment=null); 

```