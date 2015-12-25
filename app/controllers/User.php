<?php
class User extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()
            ->assign('role', getRole())
            ->assign('my_shop', getMyShop())
            ->display();
	}

    private function _index(){
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(username LIKE '%{$kw}%' OR email LIKE '%{$kw}%' OR name LIKE '%{$kw}%' OR phone LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $user_mod = m('User');
        $data = array();
        $data['data'] = $user_mod->getList($where, $order, page());
        $data['count'] = $user_mod->getCount($where);
        echo json_encode($data);
    }

	public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $row = array(
            'status' => '1',
            '_password' => '1',
            'shop_id' => session('shop_id'),
        );
        $this->view()
            ->assign('title', '新增用户')
            ->assign('action', url('User','add'))
            ->assign('row', $row)
            ->assign('role', getRole())
            ->assign('my_shop', getMyShop())
            ->display('user_form');
	}

    private function _add()
    {
        $this->verifyForm();
        $data = array();
        $data['shop_id'] = session('shop_id');
        $data['shop_name'] = session('shop_name');
        $data['username'] = post('username');
        $data['email'] = post('email');
        $data['name'] = post('name');
        $data['sex'] = post('sex');
        $data['phone'] = post('phone');
        $data['role_id'] = post('role_id');
        $data['role_name'] = getRole($data['role_id']);
        $data['create_time'] = time();
        $data['status'] = post('status');
        $password = post('password');
        if(empty($password)){
            $this->error('密码不能为空！');
        }
        if($password!=post('repassword')) {
            $this->error('两次密码不一致！');
        }
        $data['password'] = md5($password);

        $shop_mod = m('User');
        if(!$shop_mod->hasUnqiueName($data['username'])) {
            $this->error('用户名重复！');
        }
        $r = $shop_mod->insert($data); 
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            $this->success('保存成功！');
        }
    }

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('User')->getRowById(get('id'));
        $this->view()
            ->assign('title','编辑用户')
            ->assign('action', url('User','edit'))
            ->assign('row', $row)
            ->assign('role', getRole())
            ->assign('my_shop', getMyShop())
            ->display('user_form');
	}

    private function _edit()
    {
        $this->verifyForm();
        $data = array();
        $data['shop_id'] = session('shop_id');
        $data['shop_name'] = session('shop_name');
        $data['username'] = post('username');
        $data['email'] = post('email');
        $data['name'] = post('name');
        $data['sex'] = post('sex');
        $data['phone'] = post('phone');
        $data['role_id'] = post('role_id');
        $data['role_name'] = getRole($data['role_id']);
        $data['status'] = post('status');
        $password = post('password');
        if(!empty($password)) {
            if($password!=post('repassword')) {
                $this->error('两次密码不一致！');
            }
            $data['password'] = md5($password);
        }

        $shop_mod = m('User');
        $r = $shop_mod->update($data, 'id=' . post('id'));
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            $this->success('保存成功！');
        }
    }

    public function del()
    {
        $id = get('id');
        $r = m('User')->delete("id='{$id}'");
        if($r === false) {
            $this->error(m('User')->error());
        } else {
            $this->success('删除成功！');
        }
    }

    public function import()
    {
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(username LIKE '%{$kw}%' OR email LIKE '%{$kw}%' OR name LIKE '%{$kw}%' OR phone LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $user_mod = m('User');
        $data = array();
        $arr = $user_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>店铺</td>';
        $data .= '<td>用户</td>';
		$data .= '<td>姓名</td>';
        $data .= '<td>性别</td>';
        $data .= '<td>邮箱</td>';
        $data .= '<td>电话</td>';
        $data .= '<td>角色</td>';
        $data .= '<td>最后登陆时间</td>';
        $data .= '<td>最后登陆IP</td>';
        $data .= '<td>最后次数</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['username']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['sex']}</td>";
            $data .= "<td>{$val['email']}</td>";
            $data .= "<td>{$val['phone']}</td>";
            $data .= "<td>{$val['role_name']}</td>";
            $data .= '<td>'.date('Y-m-d H:i:s',$val['login_time']).'</td>';
            $data .= "<td>{$val['ip']}</td>";
            $data .= "<td>{$val['count']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'用户');
    }
}