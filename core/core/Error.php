<?php

class Error
{

    /**
     * 错误页标题
     * 
     * @var $title
     */
    private $title = '';

    /**
     * 错误标题
     * 
     * @var $heading
     */
    private $heading = '';

    /**
     * 错误详细信息
     * 
     * @var $message
     */
    private $message = '';

    /**
     * 错误信息级别
     * 
     * @var $levels
     */
    private $levels = array(
            E_ERROR => 'Error',
            E_WARNING => 'Warning',
            E_PARSE => 'Parsing Error',
            E_NOTICE => 'Notice',
            E_CORE_ERROR => 'Core Error',
            E_CORE_WARNING => 'Core Warning',
            E_COMPILE_ERROR => 'Compile Error',
            E_COMPILE_WARNING => 'Compile Warning',
            E_USER_ERROR => 'User Error',
            E_USER_WARNING => 'User Warning',
            E_USER_NOTICE => 'User Notice',
            E_STRICT => 'Runtime Notice'
    );
    
    public function start(){
        set_error_handler(array($this, 'error_handler'));
    }

    /**
     * 错误处理句柄
     * 
     * @param int $errno            
     * @param string $errstr            
     * @param string $errfile            
     * @param int $errline            
     */
    public function error_handler ($errno, $errstr, $errfile, $errline)
    {
        if($errno == E_STRICT) {
            return;
        }
        if(($errno & error_reporting()) != $errno) {
            return;
        }
        if (empty($this->title)) {
            if (isset($this->levels[$errno])) {
                $this->title = $this->levels[$errno];
            } else {
                $this->title = 'Error';
            }
        }
        if (empty($this->heading)) {
            $this->heading = 'An Error Was Encountered';
        }
        $this->message = $errstr;
        $this->error_html();
        exit;
    }

    /**
     * 触发一个 错误
     * 
     * @param string $message            
     * @param string $heading            
     * @param string $title            
     */
    public function show_error ($message, $heading = '', $title = '')
    {
        $this->title = $title;
        $this->heading = $heading;
        $message = '<p>' .
                 implode('</p><p>', 
                        (! is_array($message)) ? array(
                                $message
                        ) : $message) . '</p>';
        trigger_error($message);
    }

    /**
     * 错误页面
     */
    function error_html ()
    {
        echo '<!DOCTYPE html>
		<html>
		<head>
		<title>' . $this->title . '</title>
		<style type="text/css">
		::selection{ background-color: #E13300; color: white; }
		::moz-selection{ background-color: #E13300; color: white; }
		::webkit-selection{ background-color: #E13300; color: white; }
		body {background-color: #fff;margin: 40px;font:13px/20px normal Helvetica, Arial, sans-serif;color: #4F5155; }
		a {color: #003399;background-color: transparent;font-weight: normal; }
		h1 {color: #444;background-color: transparent;border-bottom: 1px solid #D0D0D0;font-size: 19px;font-weight: normal;margin: 0 0 14px 0;padding: 14px 15px 10px 15px;}
		code {font-family: Consolas, Monaco, Courier New, Courier, monospace;font-size: 12px;background-color: #f9f9f9;border: 1px solid #D0D0D0;color: #002166;display: block;margin: 14px 0 14px 0;padding: 12px 10px 12px 10px; }
		#container {margin: 10px;border: 1px solid #D0D0D0;-webkit-box-shadow: 0 0 8px #D0D0D0; }
		p {margin: 12px 15px 12px 15px; }
		</style>
		</head>
		<body>
			<div id="container">
				<h1>' . $this->heading . '</h1>
				' . $this->message . '
			</div>
		</body>
		</html>';
    }
}


