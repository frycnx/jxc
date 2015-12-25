<?php
class Customer extends Acl{

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
 			$where[] = "(sn like '%{$kw}%' OR 
						name like '%{$kw}%' OR 
						pinyin like '%{$kw}%' OR 
						contact like '%{$kw}%' OR 
						phone like '%{$kw}%' OR 
						memo like '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $cus_mod = m('Customer');
        $data = array();
        $data['data'] = $cus_mod->getList($where, $order, page());
        $data['count'] = $cus_mod->getCount($where);
        echo json_encode($data);
    }

    public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $row = array(
			'sn' => m('Customer')->getNewSn(option('customer_unit')),
			'shop_id' => session('shop_id'),
            'discount' => '1',
            'money' => '0.00',
            'consume' => '0.00',
            'point' => '0.00',
            'offer' => '0.00',
            'overdraft' => '0.00',
            'status' => '1'
        );
        $this->view()
            ->assign('title', '新增客户')
            ->assign('action', url('Customer','add'))
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->display('customer_form');
    }

    private function _add()
    {
        $this->verifyForm();
        $data = array();
		$data['sn'] = post('sn');
        $data['name'] = post('name');
        $data['pinyin'] = getPinYin($data['name']);
        $data['contact'] = post('contact');
        $data['phone'] = post('phone');
        $data['address'] = post('address');
        $data['memo'] = post('memo');
        //$data['money'] = post('money');
        $data['overdraft'] = post('overdraft');        
        $data['offer'] = post('offer');
        $data['consume'] = post('consume');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = getShop($data['shop_id']);
        $data['status'] = post('status');
        $data['create_time'] = time();

        $cus_mod = m('Customer');
        $r = $cus_mod->insert($data);
        if($r === false) {
            $this->error($cus_mod->error());
        } else {
            $this->success('保存成功！');
        }  
    }

    public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('Customer')->getRowById(get('id'));
        $this->view()
            ->assign('title','编辑客户')
            ->assign('action', url('Customer','edit'))
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->display('customer_form');
    }

    private function _edit()
    {
        $this->verifyForm();
        $data = array();
		$data['sn'] = post('sn');
        $data['name'] = post('name');
        $data['pinyin'] = post('pinyin');
        $data['contact'] = post('contact');
        $data['phone'] = post('phone');
        $data['address'] = post('address');
        $data['memo'] = post('memo');
        //$data['money'] = post('money');
        $data['overdraft'] = post('overdraft');        
        $data['offer'] = post('offer');
        $data['consume'] = post('consume');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = getShop($data['shop_id']);
        $data['status'] = post('status');
        $data['memo'] = post('memo');

        $cus_mod = m('Customer');
        $r = $cus_mod->update($data, 'id=' . post('id'));
        if($r === false) {
            $this->error($cus_mod->error());
        } else {
            $this->success('保存成功！');
        }
    }

    public function del()
    {
        $cus_mod = m('Customer');
        $r = $cus_mod->delete('id=' . get('id'));
        if($r === false) {
            $this->error($cus_mod->error());
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
        $kw = get('kw');
        if(!empty($kw)) {
 			$where[] = "(sn like '%{$kw}%' OR 
						name like '%{$kw}%' OR 
						pinyin like '%{$kw}%' OR 
						contact like '%{$kw}%' OR 
						phone like '%{$kw}%' OR 
						memo like '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $cus_mod = m('Customer');
        $data = array();
        $arr = $cus_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>店铺</td>';
		$data .= '<td>客户</td>';
        $data .= '<td>联系人</td>';
        $data .= '<td>电话</td>';
        $data .= '<td>地址</td>';
        $data .= '<td>预存</td>';
        $data .= '<td>欠款</td>';
        $data .= '<td>优惠</td>';
        $data .= '<td>消费</td>';
        $data .= '<td>备注</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['contact']}</td>";
            $data .= "<td>{$val['phone']}</td>";
            $data .= "<td>{$val['address']}</td>";
            $data .= "<td>{$val['money']}</td>";
            $data .= "<td>{$val['overdraft']}</td>";
            $data .= "<td>{$val['offer']}</td>";
            $data .= "<td>{$val['consume']}</td>";
            $data .= "<td>{$val['memo']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'客户');
    }
}