<?php
file_put_contents('dns','');
ini_set('display_errors','on');
$s = array_sum(explode(' ',microtime()));
/**
 * @var 系统路径
 */
define('APP_PATH', dirname(__FILE__).'/app/');
define('CORE_PATH', dirname(__FILE__).'/core/');


/**
 * 载入核心框架
 */

require CORE_PATH.'Core.php';
//echo array_sum(explode(' ',microtime()))-$s;