<?php

class Login extends Controller
{
    function __construct() {
        global $_G;
        parent::__construct();
        loadLib('Session');
        Session::start(db(),"{$_G['db_prefix']}session");
    }

    function index ()
    {
        $this->view()
            ->assign("hash",getHash())
            ->display();
    }

    function doLogin ()
    {
        if(!verifyHash($_POST['hash'])) {
            $this->error('非验证的来源！');
        }
		if(empty($_POST['username'])) {
			$this->error('帐号不能为空！');
		}
        if (empty($_POST['password'])) {
			$this->error('密码不能为空！');
		}
        if (empty($_POST['verify'])) {
			$this->error('验证码不能为空！');
		}        
        if($_SESSION['verify'] != strtolower($_POST['verify'])) {
            $this->error('验证码错误！');
        }
        $info = m('User')->getRowByName($_POST['username']);
        if(empty($info)) {
            $this->error('账号不存在');
        }

        if($info['password'] != md5($_POST['password'])) {
            $this->error('密码错误！');
        }
        $_SESSION['user_id']	=	$info['id'];
        $_SESSION['user_name']	=	$info['username'];
        $_SESSION['shop_id']	=	$info['shop_id'];
        $_SESSION['shop_name']	=	$info['shop_name'];
        $_SESSION['role_id']	=	$info['role_id'];

        $data = array();
        $data['login_time']	=	time();
        $data['ip_address']	=	getIp();
        m('User')->update($data, "id='{$info['id']}'");
        $this->success('登录成功！', url());
    }

    function security()
    {        
        $_SESSION['verify'] = strtolower(randStr(4));
        loadLib('Image');
        Image::verify($_SESSION['verify'],50,33);
        //Image::security($_SESSION['verify'], 80, 35, 20, CORE_PATH.'font/t1.ttf');
    }

    function logout ()
    {
      if(isset($_SESSION['user_id'])) {
			unset($_SESSION);
			session_destroy();
            $this->success('登出成功！', url('Login'));
        }else {
            $this->error('已经登出！', url('Login'));
        }
    }
}