<?php
class Session{
	private static $instane=NULL;
	private $db=null;
	private $gc_maxlifetime=3600;
	
	public static function start($db, $table){
		if(self::$instane == NULL){
            global $_G;
			self::$instane = new Session();
            self::$instane->table = $table;
            self::$instane->db = $db;
            session_set_save_handler(   array (self::$instane, "_open"),
                                        array (self::$instane, "_close"),
                                        array (self::$instane, "_read"),
                                        array (self::$instane, "_write"),
                                        array (self::$instane, "_destroy"),
                                        array (self::$instane, "_gc")
                                    );
            if(!empty($_COOKIE['PHPSESSID'])){
                session_id($_COOKIE['PHPSESSID']);
            }
            session_start();
        }
        return self::$instane;
	}
	
	public function _open($save_path, $session_name){
		return true;
	}
	
	public function _close(){
		//if(date('d')=='01'){
		//	$this->db->query('OPTIMIZE TABLE `{$this->table}`');
		//}
		return true;
	}
	
	public function _read($key){
		$row = $this->db->fetchArray($this->db->query("SELECT data,expiry FROM `{$this->table}` WHERE `id` = '{$key}'"));
        return isset($row['data'])? $row['data']: '';
	}
	
	public function _write($key, $val){
		$expiry=time()+$this->gc_maxlifetime;
        $user_info = '';
        if(!empty($_SESSION['user_id'])) {
            $user_info = ", user_id={$_SESSION['user_id']}";
        }
		$this->db->query("REPLACE INTO `{$this->table}` SET `id` = '{$key}', data='{$val}', expiry={$expiry}".$user_info);
	}
	
	public function _destroy($key){
		$this->db->query("DELETE FROM `{$this->table}` WHERE `id` = '{$key}' LIMIT 1");
	}
	
	public function _gc($maxlifetime){
		$this->db->query("DELETE FROM `{$this->table}` WHERE expiry < " . time());
	}
}