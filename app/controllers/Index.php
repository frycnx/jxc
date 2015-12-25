<?php

class Index extends Acl
{
    public function __construct()
    {
        parent::__construct();	
    }
    
    public function index ()
    {
        $this->view()->display();
    }

	public function profile() 
	{
        if(isPost()) {
            return $this->_profile();
        }
	    $row = m('User')->getRowById($_SESSION['user_id']);
	    $this->view()->assign('row', $row);
        $this->view()->display();
	}

    private function _profile(){
        $user_mod = m('User');
        $data=array();
        $data['email'] = post('email');
        $data['name'] = post('name');
        $data['sex'] = post('sex');
        $data['phone'] = post('phone');
        //$data['qq'] = post('qq');
		$old_password = post('old_password');
        if(!empty($old_password)) {
            $row = $user_mod->getUserById(post('user_id'));
            if(md5($old_password) != $row['password']) {
                $this->error('原密码不正确！');
            }
            if(post('new_password')!=post('re_password')) {
                $this->error('原密码不正确！');
            }
            $data['password'] = md5(post('new_password'));
        }
        $r = $user_mod->update($data, "id=".post('user_id'));
        if($r===false) {
            $this->error($user_mod->error());
        } else {
            $this->success('保存成功！');            
        }        
    }

}