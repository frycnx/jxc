<?php
class Url
{
	private $app;
	private $act;
	private $action;

	public function __construct($action='compat', $app='app', $act='act')
	{
		$this->app = $app;
		$this->act = $act;
		$this->action = $action;
        switch($this->action) {
            case 'info':
            return $this->_parse_info();
            case 'base64':
            return $this->_parse_base64();
            case 'compat':
            return $this->_parse_compat();
        }	
	}

	private function _parse_info()
	{
		if(isset($_SERVER['PATH_INFO'])){
			$paths = explode('/', trim($_SERVER['PATH_INFO'],'/'));
			$var=array();
			$var[$this->app] = array_shift($paths);
			$var[$this->act] = array_shift($paths);
			for($i=0; $i<count($paths); $i+=2){
				if(isset($paths[$i+1])) {
					$var[$paths[$i]] = strip_tags($paths[$i+1]);
				} else {
					$var[$paths[$i]] = '';
				}
			}
			foreach($_GET as $key => $val) {
				$var[$key] = $val;
			}
			$_GET   =  $var;
		}
	}

	private function _parse_base64()
	{
		if(isset($_SERVER['PATH_INFO'])){
			$paths = $this->base64_decode(urldecode(trim($_SERVER['PATH_INFO'],'/')));
			parse_str($paths, $var);
			if(!is_array($var)) {
				return;
			}
			foreach($_GET as $key => $val) {
				$var[$key] = $val;
			}
			$_GET   =  $var;
		}
	}

    private function _parse_compat()
    {
		if(isset($_GET['u'])){
			$paths = $this->base64_decode(urldecode($_GET['u']));
			parse_str($paths, $var);
			if(!is_array($var)) {
				return;
			}
			foreach($_GET as $key => $val) {
				$var[$key] = $val;
			}
			$_GET   =  $var;
		}
    }

	public function url($app='Index', $act='index', $args = array())
	{
        switch($this->action) {
            case 'info':
            return $this->_url_info($app, $act, $args);
            case 'base64':
            return $this->_url_base64($app, $act, $args);
            case 'compat':
            return $this->_url_compat($app, $act, $args);
        }
	}

	private function _url_info($app, $act, $args)
	{
		$var = array();
		foreach($args as $k => $v) {
			$var[] = $k;
			$var[] = $v;
		}
		return rtrim($_SERVER['SCRIPT_NAME'],'/')."/{$app}/{$act}/".implode('/',$var);
	}

	private function _url_base64($app, $act, $args)
	{
		return rtrim($_SERVER['SCRIPT_NAME'],'/')
				.'/'.urlencode($this->base64_encode("{$this->app}={$app}&{$this->act}={$act}".
				(count($args)<1? '': ('&' . http_build_query($args)))));
	}

	private function _url_compat($app, $act, $args)
	{
		return rtrim($_SERVER['SCRIPT_NAME'],'/')
				.'?u='.urlencode($this->base64_encode("{$this->app}={$app}&{$this->act}={$act}".
				(count($args)<1? '': ('&' . http_build_query($args)))));
	}

    private function base64_encode($str)
    {
        return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
    }

    private function base64_decode($str)
    {
        return base64_decode(str_replace(array('-','_'),array('+','/'),$str));
    }
}