<?php

namespace sashimi\DingDong\utils;

class Utils{

	public static function getGlobal(){
		$entry = ["http://api.ipify.org/", "http://ifconfig.me/ip"];
		foreach ($entry as $url){
			$ip = @file_get_contents($url);
			if($ip !== false){
				return $ip;
			}
		}

		return null;
	}

}