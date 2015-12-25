<?php
/**
 * Core 版本
 */
define('CORE_VERSION', '1.0');

/**
 * 定义全局变量
 */
$_G = array();
$_G['config_path'] = APP_PATH . 'config/';
$_G['includes_path'] = APP_PATH . 'includes/';
$_G['controllers_path'] = APP_PATH . 'controllers/';
$_G['libraries_path'] = APP_PATH . 'libraries/';
$_G['messages_path'] = APP_PATH . 'messages/';
$_G['models_path'] = APP_PATH . 'models/';
$_G['views_path'] = APP_PATH . 'views/';
$_G['tmp_path'] = APP_PATH . 'tmp/';

/**
 * 载入核心框架
 */
require CORE_PATH . 'core/Common.php';
require CORE_PATH . 'core/Controller.php';
require CORE_PATH . 'core/Error.php';
require CORE_PATH . 'core/Security.php';
require CORE_PATH . 'core/View.php';
require CORE_PATH . 'core/Model.php';
require CORE_PATH . 'core/Url.php';

/**
 * 设置系统错误处理
 */
error_reporting(E_ALL^E_NOTICE);
$ERROR = new Error();
set_error_handler(array(
        $ERROR,
        'error_handler'
));
//$URL = new Url();
if (version_compare(PHP_VERSION, '5.0.0') < 0) {
    @set_magic_quotes_runtime(0); // Kill magic quotes
}

/**
 * 载入应用核心配置
 */
foreach (glob($_G['config_path'] . '*.php') as $file) {
    require $file;
}

/**
 * 载入应用核心文件
 */
if(is_array($_G['load_file'])) {
    foreach ($_G['load_file'] as $file) {
        require $_G['includes_path'].$file;
    }
}

/**
 * 调度设置
 */
$_G['app'] = $app = 'Index';
if (! empty($_GET['app'])) {
    $_G['app'] = $app = preg_replace('/(\W+)/', '', trim($_GET['app']));
} elseif (! empty($_POST['app'])) {
    $_G['app'] = $app = preg_replace('/(\W+)/', '', trim($_POST['app']));
}

$_G['act'] = $act = 'index';
if (! empty($_GET['act'])) {
    $_G['act'] = $act = preg_replace('/(\W+)/', '', trim($_GET['act']));
} elseif (! empty($_POST['app'])) {
    $_G['act'] = $act = preg_replace('/(\W+)/', '', trim($_POST['act']));
}

/**
 * 实例化类
 */
if (! class_exists($app)) {
    if (file_exists($_G['controllers_path'] . $app . '.php')) {
        require_once $_G['controllers_path'] . $app . '.php';
    } else {
        $ERROR->show_error('App Not Found');
    }
}
$_C = new $app();

/**
 * 运行实方法
 */
if (method_exists($_C, $act)) {
    call_user_func(array($_C, $act));
} else {
    $ERROR->show_error('Act Not Found');
}

//$_C->close();

