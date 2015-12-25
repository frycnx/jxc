<?php

function get ($str, $def='')
{
    if(isset($_GET[$str])) {
        return ($_GET[$str]);
    } else {
        return $def;   
    }    
}

function post ($str, $def='')
{
    if(isset($_POST[$str])) {
        return ($_POST[$str]);
    } else {
        return $def;   
    }   
}

function request($str, $def='')
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

function session ($str, $def='')
{
    if(isset($_SESSION[$str])) {
        return ($_SESSION[$str]);
    } else {
        return $def;   
    }   
}

function cookie ($str, $def='')
{
    if(isset($_COOKIE[$str])) {
        return ($_COOKIE[$str]);
    } else {
        return $def;   
    }   
}

function db(){    
    static $db = null;
    if ($db == null) {
        global $_G;
        require CORE_PATH . 'core/Db.php';
        return $db = new Db($_G);
    }
    return $db;
}

function m($model){
    if(empty($model)) {
        return FALSE;
    }
    global $_G;
    static $models = array();
    if (isset($models[$model])) {
        return $models[$model];
    }
    $m = $_G['models_path'] . $model . '.model.php';
    if (file_exists($m)) {
        require_once $m;
    }
    $class = $model.'Model';
    if (class_exists($class)) {
        $m = $models[$model] = new $class();
        $m->db = db();
        return $m;
    } else {
        return FALSE;
    }
}

function loadLib($class)
{
    global $_G;
    if (class_exists($class)) {
        return TRUE;
    }
    $m = CORE_PATH . 'lib/' . $class . '.lib.php';
    if (file_exists($m)) {        
        require $m;
        return TRUE;
    } else {
        return FALSE;
    }
}

/*
mysql内存缓存表
CREATE TABLE IF NOT EXISTS `cache_mysq` (
            `key` varchar(255) NOT NULL,
            `val` varchar(21580) NOT NULL,
            `exp` int(10) NOT NULL,
            PRIMARY KEY (`key`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
*/
function cache($name,$value='',$expire=0)
{
    global $_G;
    $table = $_G['db_prefix'] . 'cache_mysql';
    $db = db();
    if('' === $value) {
        $row = $db->fetchArray($db->query("SELECT val,exp FROM {$table} WHERE `key`='{$name}'"));
        if(!isset($row['val'])) {
            return false;
        }
        $exp = (int)$row['exp'];
        if($exp == 0) {
            return unserialize($row['val']);
        }
        if(time() > $exp) {
            $db->execute("DELETE FROM {$table} WHERE `key`='{$name}'");
            return false;
        }
        return unserialize($row['val']);
    } else {
        if(is_null($value)) {
            return $db->execute("DELETE FROM {$table} WHERE `key`='{$name}'");
        } else {
            $val = serialize($value);
            $time = $expire>0? time()+$expire: '0';
            return $db->execute("REPLACE INTO {$table}(`key`,`val`,`exp`) VALUES('{$name}','{$val}',{$time})");
        }
    }		
}

/**
 * 判断是否是ajax请求
 *
 * @return boolean
 */
function isAjax ()
{
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    }
    return FALSE;
    
}

function isPost()
{
    return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
}

/**
 * 生成url
 *
 * @param string $app            
 * @param string $act            
 * @param array $args            
 */
function url ($app='Index', $act='index', $args = array())
{
    global $URL;
	if(is_object($URL)&&method_exists($URL,'url')) {
        return $URL->url($app, $act, $args);
    }
//    $url = rtrim(str_replace($_SERVER['HTTP_HOST'],'',array_shift(explode('.php',$_SERVER['PHP_SELF'])).'.php'),'/');
    $url = rtrim($_SERVER['SCRIPT_NAME'],'/');
    $url .= "?app={$app}&act={$act}";
    $url .= count($args) < 1 ? '' : ('&' . http_build_query($args));
    return $url;
}

/**
 * 生成随机数
 *
 * @param int $length            
 * @param number $type            
 * @return string
 */
function randStr ($length = 6, $type = 0)
{
    switch ($type) {
        case 1:
            $chars = '0123456789';
            break;
        case 2:
            $chars = 'abcdefghijklmnopqrstuvwxyz';
            break;
        case 3:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            break;
        case 4:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
        default:
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
    }
    $max = strlen($chars) - 1;
    $hash = '';
    for ($i = 0; $i < $length; $i ++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 获取系统URL
 *
 * @return Ambigous <>|mixed
 */
function baseUrl ()
{
    global $_G;
    if (! empty($_G['base_url'])) {
        return $_G['base_url'];
    }
    $url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
    $url .= '://' . $_SERVER['HTTP_HOST'];
    $url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', 
            $_SERVER['SCRIPT_NAME']);
    return $GLOBALS['_G'] = $url;
}

/**
 * 获取IP
 *
 * @return NULL|Ambigous <NULL, string>
 */
function getIp ()
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
