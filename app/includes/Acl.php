<?php
class Acl extends Controller 
{

    function __construct()
    {
        global $_G;
        parent::__construct();
        loadLib('Session');
        Session::start(db(),"{$_G['db_prefix']}session");
        if(empty($_SESSION['user_id'])){
            header('Location: '.url('Login'));
        }
        //$this->checkRole();
    }

    function verifyForm()
    {
		if(!verifyHash($_POST['hash'])) {
            $this->error('非验证的来源！');
        }
    }

    function clearForm()
    {
        unset($_SESSION['hash_code']);
    }

    function checkRole()
    {
        global $_G;
        if(!in_array("{$_G['app']}/{$_G['act']}",getMyRight())) {
            $this->error('您无权限访问此页！');
        }
    }

}