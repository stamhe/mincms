<?php namespace application\core;  
/**
* Str class
* @author Sun <mincms@outlook.com>
* @copyright 2013 The MinCMS Group
* @license http://mincms.com/licenses
* @version 2.0.1
*/
class Str{
   /**
	* currencies 
	* 
	* @link http://xurrency.com/currencies currencies
	*
	* Example:
	* <code> 
	* \application\core\Str::currencies(1,'eur','rmb');
	* </code>  
	* @param  int $num   100
	* @param  string $from  params 
	* @param  string $to  params 
	*/
   static function currencies($num,$from, $to ){
		$url = "http://www.google.com/ig/calculator?hl=en&q=".$num.$from."=?".$to;
		$data = file_get_contents($url);
		$data = explode('"', $data);
		$data = explode(' ', $data['3']);
		$var = $data['0'];
		return round($var,2); 
   }
   
   function multiexplode ($delimiters,$string) { 
	    $ready = str_replace($delimiters, $delimiters[0], $string);
	    $launch = explode($delimiters[0], $ready);
	    return  $launch;
	}
	function srand($j = 8){
		$string = "";
	    for($i=0;$i < $j;$i++){
	        srand((double)microtime()*1234567);
	        $x = mt_rand(0,2);
	        switch($x){
	            case 0:$string.= chr(mt_rand(97,122));break;
	            case 1:$string.= chr(mt_rand(65,90));break;
	            case 2:$string.= chr(mt_rand(48,57));break;
	        }
	    }
		return strtoupper($string); //to uppercase
	}
 	
	/**
	* 批量替换
	*/
	static function new_replace($body,$replace=array()){ 
		foreach($replace as $k=>$v){
			$body = str_replace($k,$v,$body);
		}
	 	return $body;
	}
	static function value($value){
		if(!static::is_utf8($value)){
			$value = utf8_encode($value);
		}
		return $value;
	}
	/**
	 * 判断字符串是否为utf8编码，
	 * 英文和半角字符返回ture 
	 */
	static function is_utf8($string) {
		return preg_match('%^(?:
		[\x09\x0A\x0D\x20-\x7E] # ASCII
		| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
		| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
		| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
		| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
		| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
		| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
		| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
		)*$%xs', $string);
	}
	/**
	*截取字符串
	*/
	static function cut($str, $length,$ext='...') {
		$str = trim(strip_tags($str));
		global $s;
		$i = 0;
		$len = 0;
		$slen = strlen($str);
		$s = $str;
		$f = true; 
		while ($i <= $slen) {
			if (ord($str{$i}) < 0x80) {
				$len++; $i++;
			} 
			else if (ord($str{$i}) < 0xe0) {
				$len++; $i += 2;
			} 
			else if (ord($str{$i}) < 0xf0) {
				$len += 2; $i += 3;
			} 
			else if (ord($str{$i}) < 0xf8) {
				$len += 1; $i += 4;
			} 
			else if (ord($str{$i}) < 0xfc) {
				$len += 1; $i += 5;
			} 
			else if (ord($str{$i}) < 0xfe) {
				$len += 1; $i += 6;
			}

			if (($len >= $length - 1) && $f) {
				$s = substr($str, 0, $i);
				$f = false;
			}

			if (($len > $length) && ($i < $slen)) {
				$s = $s . $ext; break;  
			}
		}
		return $s;
	}

	//统计字符串长度-UTF8 (PHP) 
	static function len($str) { 
	     $count = 0; 
	     for($i = 0; $i < strlen($str); $i++){ 
	         $value = ord($str[$i]); 
	         if($value > 127) { 
	             $count++; 
	             if($value >= 192 && $value <= 223) $i++; 
	             elseif($value >= 224 && $value <= 239) $i = $i + 2; 
	             elseif($value >= 240 && $value <= 247) $i = $i + 3; 
	             else die('Not a UTF-8 compatible string'); 
	         } 
	         $count++; 
	     } 
	     return $count; 
	} 
	/**
	 +----------------------------------------------------------
	 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
	 +----------------------------------------------------------
	 * @param string $len 长度
	 * @param string $type 字串类型
	 * 0 字母 1 数字 其它 混合
	 * @param string $addChars 额外字符
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	static function rand($len=6,$type='',$addChars='') {
		$str ='';
		switch($type) {
			case 0:
				$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890'.$addChars;
				break;
			case 1:
				$chars= str_repeat('0123456789',3);
				break;
			case 2:
				$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
				break;
			case 3:
				$chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
				break;
			case 4:
				$chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
				break;
			default :
				// 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
				$chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
				break;
		} 
		if($len>10 ) {//位数过长重复字符串一定次数
			$chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
		}
		if($type!=4) {
			$chars   =   str_shuffle($chars);
			$str     =   substr($chars,0,$len);
		}else{
			// 中文随机字
			for($i=0;$i<$len;$i++){
				$str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
			}
		}
		return $str;
	}

	static function clean($content){
		$content = preg_replace("/style=.+?['|\"]/i",'',$content);//去除样式  
		$content = preg_replace("/class=.+?['|\"]/i",'',$content);//去除样式  
		$content = preg_replace("/id=.+?['|\"]/i",'',$content);//去除样式     
		$content = preg_replace("/lang=.+?['|\"]/i",'',$content);//去除样式      
		$content = preg_replace("/width=.+?['|\"]/i",'',$content);//去除样式   
		$content = preg_replace("/height=.+?['|\"]/i",'',$content);//去除样式   
		$content = preg_replace("/border=.+?['|\"]/i",'',$content);//去除样式   
		$content = preg_replace("/face=.+?['|\"]/i",'',$content);//去除样式   
		$content = preg_replace("/face=.+?['|\"]/",'',$content);//去除样式 只允许小写 正则匹配没有带 i 参数  
		return $content;
	}
	/**
	 * Escape String
	 *
	 * @access	public
	 * @param	string
	 * @param	bool	whether or not the string will be used in a LIKE condition
	 * @return	string
	 */
	static function escape_str($str, $like = FALSE)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = static::escape_str($val, $like);
			} 
			return $str;
		}  
		$str = addslashes($str); 
		if ($like === TRUE)
		{
			$str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
		}

		return $str;
	}
	 
}