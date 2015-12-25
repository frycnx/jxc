<?php
class Input {

	public function get ($str, $def='')
	{
		if(isset($_GET[$str])) {
			return ($_GET[$str]);
		} else {
			return $def;   
		}    
	}

	public function post ($str, $def='')
	{
		if(isset($_POST[$str])) {
			return ($_POST[$str]);
		} else {
			return $def;   
		}   
	}

	public function request($str, $def='')
	{
		if(isset($_REQUEST[$str])) {
			return ($_REQUEST[$str]);
		} else if(isset($_POST[$str])) {
			return ($_POST[$str]);
		} else if(isset($_GET[$str])) {
			return ($_GET[$str]);
		} else {
			return $def;   
		}
	}

	public function session ($str, $def='')
	{
		if(isset($_SESSION[$str])) {
			return ($_SESSION[$str]);
		} else {
			return $def;   
		}   
	}

	public function cookie ($str, $def='')
	{
		if(isset($_COOKIE[$str])) {
			return ($_COOKIE[$str]);
		} else {
			return $def;   
		}   
	}

	public function xssClean($str)
	{
		if(is_array($str)) {
			foreach($str as $key => $val) {
				$str[$key] = $this->xssClean($val);
			}
			return $str;
		}
		return rawurldecode($str);
	}

	public function getIp ()
	{
		static $realip = NULL;
		if ($realip !== NULL) {
			return $realip;
		}
		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				
				/* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
				foreach ($arr as $ip) {
					$ip = trim($ip);
					if ($ip != 'unknown') {
						$realip = $ip;
						break;
					}
				}
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset($_SERVER['REMOTE_ADDR'])) {
					$realip = $_SERVER['REMOTE_ADDR'];
				} else {
					$realip = '0.0.0.0';
				}
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif (getenv('HTTP_CLIENT_IP')) {
				$realip = getenv('HTTP_CLIENT_IP');
			} else {
				$realip = getenv('REMOTE_ADDR');
			}
		}
		return $realip;
	}

	/**
	 * 判断是否是ajax请求
	 *
	 * @return boolean
	 */
	public function isAjax ()
	{
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return FALSE;
		}
		return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}

	public function isPost()
	{
		return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
	}

	public function isCli()
	{
		return defined('STDIN') || strtolower(php_sapi_name()) === 'cli';
	}
	
}