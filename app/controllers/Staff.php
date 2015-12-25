<?php
class Staff extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()
            ->assign('my_shop', getMyShop())
            ->display();
	}

    private function _index(){
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id && in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(name LIKE '%{$kw}%' OR email LIKE '%{$kw}%' OR phone LIKE '%{$kw}%' OR join_time LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Staff');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

	public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $row = array(
            'status' => '1',
            'shop_id' => session('shop_id'),
            'join_time' => date('Y-m-d')
        );
        $this->view()
            ->assign('title', '新增员工')
            ->assign('action', url('Staff','add'))
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->display('staff_form');
	}

    private function _add()
    {
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
        $data['sex'] = post('sex');
        $data['birth'] = post('birth');
        $data['email'] = post('email');
        $data['phone'] = post('phone');
        $data['address'] = post('address');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = getShop($data['shop_id']);
        $data['join_time'] = post('join_time');
        $data['create_time'] = time();
        $data['status'] = post('status');
        $data['memo'] = post('memo');

        $shop_mod = m('Staff');
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
        $row = m('Staff')->getRowById(get('id'));
        $this->view()
            ->assign('title','编辑员工')
            ->assign('action', url('Staff','edit'))
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->display('staff_form');
	}

    private function _edit()
    {
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
        $data['sex'] = post('sex');
        $data['birth'] = post('birth');
        $data['email'] = post('email');
        $data['phone'] = post('phone');
        $data['address'] = post('address');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = getShop($data['shop_id']);
        $data['join_time'] = post('join_time');
        $data['create_time'] = time();
        $data['status'] = post('status');
        $data['memo'] = post('memo');

        $shop_mod = m('Staff');
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
        $r = m('Staff')->delete("id='{$id}'");
        if($r === false) {
            $this->error(m('Staff')->error());
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
            $where[] = "(name LIKE '%{$kw}%' OR email LIKE '%{$kw}%' OR phone LIKE '%{$kw}%' OR join_time LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Staff');
        $data = array();
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>店铺</td>';
		$data .= '<td>姓名</td>';
        $data .= '<td>性别</td>';
        $data .= '<td>生日</td>';
        $data .= '<td>邮箱</td>';
        $data .= '<td>电话</td>';
        $data .= '<td>地址</td>';
        $data .= '<td>加入时间</td>';
        $data .= '<td>备注</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['sex']}</td>";
            $data .= "<td>{$val['birth']}</td>";
            $data .= "<td>{$val['email']}</td>";
            $data .= "<td>{$val['phone']}</td>";
            $data .= "<td>{$val['address']}</td>";
            $data .= '<td>'.date('Y-m-d',$val['join_time']).'</td>';
            $data .= "<td>{$val['memo']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'员工');
    }
}