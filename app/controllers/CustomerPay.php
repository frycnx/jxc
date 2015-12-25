<?php
class CustomerPay extends Acl{

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
            $where[] = "(customer_sn like '%{$kw}%' OR 
						customer_name like '%{$kw}%' OR 
						customer_pinyin like '%{$kw}%' OR 
						customer_contact like '%{$kw}%' OR 
						customer_phone like '%{$kw}%')";
        }
        $start = get('start_time');
        if(!empty($start)) {
            $where[] = 'create_time>'.strtotime($start);
        }
        $end = get('end_time');
        if(!empty($end)) {
            $where[] = 'create_time<'.(strtotime($end)+24*3600);
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }
        $csut_mod = m('CustomerPay');
        $data = array();
        $data['data'] = $csut_mod->getList($where, $order, page());
        $data['count'] = $csut_mod->getCount($where);
        echo json_encode($data);
    }

    public function customer()
    {
        if(isAjaxTable()) {
            return $this->_customer();
        }
        $this->view()
            ->assign('my_shop', getMyShop())
            ->display();
    }

    private function _customer()
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
 			$where[] = "(name like '%{$kw}%' OR 
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
        $row = m('Customer')->getRowById(get('id'));
        $this->view()
            ->assign('title','客户收款')
            ->assign('action', url('CustomerPay','add'))
            ->assign('row', $row)
            ->display('customerpay_form');
    }

    public function _add()
    {
        $this->verifyForm();
		$row = m('Customer')->getRowById(post('id'));
        if(!$row['id']) {
            $this->error('客户不存在！');
        }
        $data = array();
        $data['user_id'] = session('user_id');
        $data['user_name'] = session('user_name');
        $data['shop_id'] = $row['shop_id'];
        $data['shop_name'] = $row['shop_name'];
        $data['customer_id'] = $row['id'];
		$data['customer_sn'] = $row['sn'];
        $data['customer_name'] = $row['name'];
        $data['customer_pinyin'] = $row['pinyin'];
        $data['customer_contact'] = $row['contact'];
        $data['customer_phone'] = $row['phone'];
        $data['customer_money'] = $row['money'];
        $data['customer_overdraft'] = $row['overdraft'];
        $data['customer_offer'] = $row['offer'];        
        $data['customer_consume'] = $row['consume'];
		$data['pay'] = (float)str_replace(' ','',post('pay'));
		$data['offer'] = (float)str_replace(' ','',post('offer'));
        $data['create_time'] = time();
		$data['memo'] = post('memo');

        $csut_mod = m('CustomerPay');
		$csut_mod->startTrans();
		$r = $csut_mod->insert($data);            
        if($r === false) {
			$csut_mod->rollBack();
            $this->error($csut_mod->error());
        }
		$r = m('Customer')->updateMoney("id={$row['id']}",array(
							'overdraft' => (0-$data['pay']-$data['offer']),
							'offer'=>$data['offer']
						));
        if($r === false) {
			$csut_mod->rollBack();
            $this->error($csut_mod->error());
        }
		$csut_mod->commit();
		$this->success('保存成功！');
    }

    public function del()
    {
        $id = get('id');
        $csut_mod = m('Customer');
        $r = $csut_mod->delete("id='{$id}'");
        if($r === false) {
            $this->error($csut_mod->error());
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
            $where[] = "(customer_sn like '%{$kw}%' OR 
						customer_name like '%{$kw}%' OR 
						customer_pinyin like '%{$kw}%' OR 
						customer_contact like '%{$kw}%' OR 
						customer_phone like '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }
        $csut_mod = m('CustomerPay');
        $arr = $csut_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>店铺</td>';
		$data .= '<td>客户</td>';
        $data .= '<td>联系人</td>';
        $data .= '<td>电话</td>';
        $data .= '<td>当前欠款</td>';
        $data .= '<td>当前优惠</td>';
        $data .= '<td>当前消费</td>';
        $data .= '<td>收款</td>';
        $data .= '<td>优惠</td>';
        $data .= '<td>操作员</td>';
        $data .= '<td>备注</td>';
        $data .= '<td>时间</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['customer_name']}</td>";
            $data .= "<td>{$val['customer_contact']}</td>";
            $data .= "<td>{$val['customer_phone']}</td>";
            $data .= "<td>{$val['customer_overdraft']}</td>";
            $data .= "<td>{$val['customer_offer']}</td>";
            $data .= "<td>{$val['customer_consume']}</td>";
            $data .= "<td>{$val['pay']}</td>";
            $data .= "<td>{$val['offer']}</td>";
            $data .= "<td>{$val['user_name']}</td>";
            $data .= "<td>{$val['memo']}</td>";
            $data .= '<td>'.date('Y-m-d H:i:s',$val['create_time']).'</td>';
            $data .= '</tr>';
        }
        echo outXls($data,'客户收款');
    }
}