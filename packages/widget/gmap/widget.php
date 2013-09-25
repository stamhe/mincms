<?php namespace application\widget\gmap;  
use yii\helpers\Json;
/**
<div id="map" style="width:300px;height:300px;"></div>
<?php widget('gmap',array(
	'tag'=>'map',
	'address'=>'上海',	
));?>
* @author Sun < mincms@outlook.com >
*/
class Widget extends \yii\base\Widget
{  
 	public $tag;
 	public $aid;  
 	public $address;
	function run(){   
		$id = $this->tag;
		$id = str_replace('#','',$id);
		$id = str_replace('.','',$id);
		$aid = $this->aid;
		$address = $this->address;
	 	js_file('https://maps.googleapis.com/maps/api/js?sensor=false');
		if($aid) $adword = "var adUnitDiv = document.createElement('div');
		var adUnitOptions = {
		  format: google.maps.adsense.AdFormat.VERTICAL_BANNER,
		  position: google.maps.ControlPosition.RIGHT_CENTER,
		  publisherId: '".$aid."',
		  map: map,
		  visible: true
		};
		var adUnit = new google.maps.adsense.AdUnit(adUnitDiv, adUnitOptions);";
		js(" 
			var geocoder, map, adUnit;
			function codeAddress(address) {
			    geocoder = new google.maps.Geocoder();
			    geocoder.geocode( { 'address': address}, function(results, status) {
			      if (status == google.maps.GeocoderStatus.OK) {
			        var myOptions = {
				        zoom: 14,
				        center: results[0].geometry.location,
				        mapTypeId: google.maps.MapTypeId.ROADMAP
			        };
			        map = new google.maps.Map(document.getElementById('".$id."'), myOptions); 
			        var marker = new google.maps.Marker({
			            map: map,
			            position: results[0].geometry.location
			        }); 
			        ".$adword." 
			      }
			    }); 
			 } 
			codeAddress('".$address."');
		"); 
	}
}