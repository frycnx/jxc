<?php
class xxtea {
	public $_key='';
	public $crypt_xxtea_delta = 0x9E3779B9;
	
	public function __construct($key='') {
		if(!empty($key)){
			$this->setKey ( $key );
		}
	}
	
	// 加密字符
	public function encrypt($plaintext) {
		if ($this->_key == null) {
			return ('Secret key is undefined.');
		}
		if (is_string ( $plaintext )) {
			return base64_encode ( $this->_encryptString ( $plaintext ) );
		} elseif (is_array ( $plaintext )) {
			return base64_encode ( $this->_encryptArray ( $plaintext ) );
		} else {
			return false;
		}
	}
	
	// 解密字符
	public function decrypt($chipertext) {
		$chipertext = base64_decode ( $chipertext );
		if ($this->_key == null) {
			return ('Secret key is undefined.');
		}
		if (is_string ( $chipertext )) {
			return $this->_decryptString ( $chipertext );
		} elseif (is_array ( $chipertext )) {
			return $this->_decryptArray ( $chipertext );
		} else {
			return false;
		}
	}
	
	// 设置加密key
	public function setKey($key) {
		if (is_string ( $key )) {
			$k = $this->_str2long ( $key, false );
		} elseif (is_array ( $key )) {
			$k = $key;
		} else {
			return ('The secret key must be a string or long integer array.');
		}
		if (count ( $k ) > 4) {
			return ('The secret key cannot be more than 16 characters or 4 long values.');
		} elseif (count ( $k ) == 0) {
			return ('The secret key cannot be empty.');
		} elseif (count ( $k ) < 4) {
			for($i = count ( $k ); $i < 4; $i ++) {
				$k [$i] = 0;
			}
		}
		$this->_key = $k;
		return true;
	}
	private function _encryptString($str) {
		if ($str == '') {
			return '';
		}
		$v = $this->_str2long ( $str, true );
		$v = $this->_encryptArray ( $v );
		return $this->_long2str ( $v, false );
	}
	private function _encryptArray($v) {
		$n = count ( $v ) - 1;
		$z = $v [$n];
		$y = $v [0];
		$q = floor ( 6 + 52 / ($n + 1) );
		$sum = 0;
		while ( 0 < $q -- ) {
			$sum = $this->_int32 ( $sum + $this->crypt_xxtea_delta );
			$e = $sum >> 2 & 3;
			for($p = 0; $p < $n; $p ++) {
				$y = $v [$p + 1];
				$mx = $this->_int32 ( (($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4) ) ^ $this->_int32 ( ($sum ^ $y) + ($this->_key [$p & 3 ^ $e] ^ $z) );
				$z = $v [$p] = $this->_int32 ( $v [$p] + $mx );
			}
			$y = $v [0];
			$mx = $this->_int32 ( (($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4) ) ^ $this->_int32 ( ($sum ^ $y) + ($this->_key [$p & 3 ^ $e] ^ $z) );
			$z = $v [$n] = $this->_int32 ( $v [$n] + $mx );
		}
		return $v;
	}
	private function _decryptString($str) {
		if ($str == '') {
			return '';
		}
		$v = $this->_str2long ( $str, false );
		$v = $this->_decryptArray ( $v );
		return $this->_long2str ( $v, true );
	}
	private function _decryptArray($v) {
		$n = count ( $v ) - 1;
		$z = $v [$n];
		$y = $v [0];
		$q = floor ( 6 + 52 / ($n + 1) );
		$sum = $this->_int32 ( $q * $this->crypt_xxtea_delta );
		while ( $sum != 0 ) {
			$e = $sum >> 2 & 3;
			for($p = $n; $p > 0; $p --) {
				$z = $v [$p - 1];
				$mx = $this->_int32 ( (($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4) ) ^ $this->_int32 ( ($sum ^ $y) + ($this->_key [$p & 3 ^ $e] ^ $z) );
				$y = $v [$p] = $this->_int32 ( $v [$p] - $mx );
			}
			$z = $v [$n];
			$mx = $this->_int32 ( (($z >> 5 & 0x07FFFFFF) ^ $y << 2) + (($y >> 3 & 0x1FFFFFFF) ^ $z << 4) ) ^ $this->_int32 ( ($sum ^ $y) + ($this->_key [$p & 3 ^ $e] ^ $z) );
			$y = $v [0] = $this->_int32 ( $v [0] - $mx );
			$sum = $this->_int32 ( $sum - $this->crypt_xxtea_delta );
		}
		return $v;
	}
	private function _long2str($v, $w) {
		$len = count ( $v );
		$s = '';
		for($i = 0; $i < $len; $i ++) {
			$s .= pack ( 'V', $v [$i] );
		}
		if ($w) {
			return substr ( $s, 0, $v [$len - 1] );
		} else {
			return $s;
		}
	}
	private function _str2long($s, $w) {
		$v = array_values ( unpack ( 'V*', $s . str_repeat ( "\0", (4 - strlen ( $s ) % 4) & 3 ) ) );
		if ($w) {
			$v [] = strlen ( $s );
		}
		return $v;
	}
	private function _int32($n) {
		while ( $n >= 2147483648 ) {
			$n -= 4294967296;
		}
		while ( $n <= - 2147483649 ) {
			$n += 4294967296;
		}
		return ( int ) $n;
	}
}