<?php
class Member extends Acl{
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
        $this->view()
            ->assign('my_shop', getMyShop())
            ->assign('member_level', getMemberLevel())
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
        $level_id = get('level_id');
        if(!empty($level_id)) { 
            $where[] = " level_id ='{$level_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
 			$where[] = "(card like '%{$kw}%' OR 
						name like '%{$kw}%' OR 
						pinyin like '%{$kw}%' OR 
						birth like '%{$kw}%' OR 
						phone like '%{$kw}%' OR 
						address like '%{$kw}%' OR 
						memo like '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $member_mod = m('Member');
        $data = array();
        $data['data'] = $member_mod->getList($where, $order, page());
        $data['count'] = $member_mod->getCount($where);
        echo json_encode($data);
    }

    public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $row = array(
			'card' => m('Member')->getNewCard(option('member_unit')),
            'shop_id' => session('shop_id'),
            'level_discount' => '1',
            'money' => '0.00',
            'consume' => '0.00',
            'point' => '0.00'
        );
        $this->view()
			->assign('title', '新增会员')
            ->assign('action', url('Member','add'))
			->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->assign('member_level', getMemberLevel())
			->display('member_form');
    }

	private function _add()
	{
        $this->verifyForm();
        $data = array();
        $data['card'] = post('card');
        $data['name'] = post('name');
        $data['pinyin'] = getPinYin($data['name']);
        $data['sex'] = post('sex');
        $data['birth'] = post('birth');
        $data['phone'] = post('phone');
        $data['address'] = post('address');
        $data['money'] = post('money');
        $data['consume'] = post('consume');
        $data['point'] = post('point');
        $data['password'] = post('password');
        $data['level_id'] = post('level_id');
		$level = getMemberLevel($data['level_id']);
        $data['level_name'] = $level['name'];
        $data['level_discount'] = $level['discount'];  
		$data['shop_id'] = post('shop_id');
		$data['shop_name'] = getShop($data['shop_id']);
		$data['memo'] = post('memo');
        $data['create_time'] = time();

        $member_mod = m('Member');
		$r = $member_mod->insert($data);
        if($r === false) {
            $this->error($member_mod->error());
        } else {
            $this->success('保存成功！');
        }
	}

    public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('Member')->getRowById(get('id'));
        $this->view()
			->assign('title','编辑会员')
            ->assign('action', url('Member','edit'))
			->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->assign('member_level', getMemberLevel())
			->display('member_form');
    }

	private function _edit()
	{
        $this->verifyForm();
        $data = array();
        $data['card'] = post('card');
        $data['name'] = post('name');
        $data['pinyin'] = getPinYin($data['name']);
        $data['sex'] = post('sex');
        $data['birth'] = post('birth');
        $data['phone'] = post('phone');
        $data['address'] = post('address');
        $data['money'] = post('money');
        $data['consume'] = post('consume');
        $data['point'] = post('point');
        $data['password'] = post('password');
        $data['level_id'] = post('level_id');
		$level = getMemberLevel($data['level_id']);
        $data['level_name'] = $level['name'];
        $data['level_discount'] = $level['discount'];
		$data['shop_id'] = post('shop_id');
		$data['shop_name'] = getShop($data['shop_id']);
		$data['memo'] = post('memo');
		
        $member_mod = m('Member');
		$r = $member_mod->update($data, 'id=' . post('id'));
        if($r === false) {
            $this->error($member_mod->error());
        } else {
            $this->success('保存成功！');
        }
	}

    public function del()
    {
        $id = get('id');
        $member_mod = m('Member');
        $r = $member_mod->delete("id='{$id}'");
        if($r === false) {
            $this->error($member_mod->error());
        } else {
            $this->success('删除成功！');
        }
    }

    public function import()
    {
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id && in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $level_id = get('level_id');
        if(!empty($level_id)) { 
            $where[] = " level_id ='{$level_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
 			$where[] = "(card like '%{$kw}%' OR 
						name like '%{$kw}%' OR 
						pinyin like '%{$kw}%' OR 
						birth like '%{$kw}%' OR 
						phone like '%{$kw}%' OR 
						address like '%{$kw}%' OR 
						memo like '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $member_mod = m('Member');
        $arr = $member_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>卡号</td>';
		$data .= '<td>姓名</td>';
        $data .= '<td>性别</td>';
        $data .= '<td>生日</td>';
        $data .= '<td>电话</td>';
        $data .= '<td>地址</td>';
        $data .= '<td>预存</td>';
        $data .= '<td>消费</td>';
        $data .= '<td>积分</td>';
        $data .= '<td>级别</td>';
        $data .= '<td>折扣</td>';
        $data .= '<td>店铺</td>';
        $data .= '<td>备注</td>';
        $data .= '<td>创建时间</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['card']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['sex']}</td>";
            $data .= "<td>{$val['birth']}</td>";
            $data .= "<td>{$val['phone']}</td>";
            $data .= "<td>{$val['address']}</td>";
            $data .= "<td>{$val['money']}</td>";
            $data .= "<td>{$val['consume']}</td>";
            $data .= "<td>{$val['point']}</td>";
            $data .= "<td>{$val['level_name']}</td>";
            $data .= "<td>{$val['level_discount']}</td>";
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['memo']}</td>";
            $data .= '<td>'.date('Y-m-d H:i:s',$val['create_time']).'</td>';
            $data .= '</tr>';
        }
        echo outXls($data,'会员');
    }
}