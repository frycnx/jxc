<?php
class Trade extends Acl{
	public function __construct()
    {
		parent::__construct();
	}
	
	public function index()
    {
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()
            ->assign('my_shop', getMyShop())
            ->display();
	}

    private function _index()
    {
        $where = array();
        $shop_ids = getMyShopId();
        $shop_id = get('shop_id');
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sn LIKE '%{$kw}%' OR 
                        user_name LIKE '%{$kw}%' OR 
                        memo LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $trade_mod = m('Trade');
        $data = array();
        $data['data'] = $trade_mod->getList($where, $order, page());
        $data['count'] = $trade_mod->getCount($where);
        echo json_encode($data);
    }

    public function getId($status,$row=array())
    {
        $data = array();
        $data['sn'] = post('sn');
        $data['user_id'] = session('user_id');
        $data['user_name'] = session('user_name');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = getShop($data['shop_id']);
        $data['customer_id'] = post('customer_id');
        $data['customer_name'] = post('customer_name');
        $data['customer_contact'] = post('customer_contact');        
        $data['customer_consume'] = post('customer_consume');
        $data['customer_money'] = post('customer_money');
        $data['customer_offer'] = post('customer_offer');
        $data['customer_overdraft'] = post('customer_overdraft');
        $data['ysje'] = post('ysje');
        $data['ssje'] = post('ssje');
        $data['yhje'] = post('yhje');
        $data['qkje'] = post('qkje');
        $data['khyc'] = post('khyc');
        $data['status'] = $status;
        $data['memo'] = post('memo');
        return m('Trade')->add($data,$row);
    }

    public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $sn = get('sn');
        if(empty($sn)) {
            $row = array(
                'sn' => m('Trade')->getSn(),
                'shop_id' => session('shop_id'),
                'user_name' => session('user_name'),
                'status' => '0'
            );
        } else {
            $row = m('Trade')->getRowBySn($sn);
        }
        $this->view()
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
            ->display();
    }

    private function _add()
    {
        $row = m('Trade')->getRowBySn(post('sn'));
        $r = $this->getId('0',$row);
        if($r === false) {
            $this->error(m('Trade')->error());
        } else {
            $this->success('增加成功！');
        }
    }

    public function del()
    {
        $id = get('id');
        $trade_mod = m('Trade');
        $trade_mod->startTrans();
        $r = $trade_mod->delete("id={$id}");
        if($r === false) {
            $trade_mod->rollBack();
            $this->error($trade_mod->error());
        }
        $r = m('TradeGoods')->delete("outcome_id={$id}");
        if($r === false) {
            $trade_mod->rollBack();
            $this->error($trade_mod->error());
        }
        $trade_mod->commit();
        $this->success('删除成功！');
    }

    public function save()
    {
        //保存单据
        $mod = m('Trade');
        $mod->startTrans();
        $row = $mod->getRowBySn(post('sn'));
        if($row['status']) {
            $mod->rollBack();
            $this->error('单据已完成!');
        }
        $id = $this->getId('1',$row);
        if( !$id ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        //处理库存
        $r = m('TradeGoods')->changeStock($row);
        if( !$r ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        $mod->commit();
        $this->success('保存成功！');
    }

    public function customer()
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
        $data['data'] = $cus_mod->getList($where, $order, page());
        $data['count'] = $cus_mod->getCount($where);
        echo json_encode($data);
    }

    public function goods()
    {
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id={$cate_id}";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sku LIKE '%{$kw}%' OR 
                        name LIKE '%{$kw}%' OR 
                        pinyin LIKE '%{$kw}%' OR 
                        barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $trade_mod = m('Stock');
        $data = array();
        $data['data'] = $trade_mod->getList($where, $order, page());
        $data['count'] = $trade_mod->getCount($where);
        echo json_encode($data);
    }

    public function getGoods()
    {
        $sn = get('sn');        
        if(empty($sn)) {
            echo json_encode(array());
        }
        $where = "trade_sn='{$sn}'";
        $data = m('TradeGoods')->getList($where);
        echo json_encode($data);
    }

    public function addGoods()
    {
        //增加商品
        $row = m('Trade')->getRowBySn(post('sn'));
        $data = array();
        $data['trade_id'] = $this->getId('0',$row);
        $data['trade_sn'] = post('sn');
        $data['goods_id'] = post('goods_id');
        $data['discount'] = post('discount');
        $data['amount'] = post('amount');
        $data['price'] = post('price');
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        $r = m('TradeGoods')->add($data);
        if($r === false) {
            $this->error(m('TradeGoods')->error());
        } else {
            $this->success('增加成功！');
        }
    }

    public function editGoods()
    {
        //编辑商品
        $id = post('id');
        $data = array();        
        $data['amount'] = post('amount');
        $data['discount'] = post('discount');
        $data['price'] = post('price');
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        $r = m('TradeGoods')->update($data, "id='{$id}'");
        if($r === false) {
            $this->error(m('TradeGoods')->error());
        } else {
            $this->success('增加成功！');
        }
    }

    public function delGoods()
    {
        $id = get('id');
        if($id) {
            $r = m('TradeGoods')->delete("id={$id}");
        }
        $sn = get('sn');
        if($sn) {
            $r = m('TradeGoods')->delete("trade_sn='{$sn}'");
        }
        if($r === false) {
            $this->error(m('TradeGoods')->error());
        } else {
            $this->success('删除成功！');
        }
    }

    public function import()
    {
        $where = array();
        $shop_ids = getMyShopId();
        $shop_id = get('shop_id');
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sn LIKE '%{$kw}%' OR 
                        user_name LIKE '%{$kw}%' OR 
                        memo LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $trade_mod = m('Trade');
        $arr = $trade_mod->getList($where, $order, page());
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>单号</td>';
		$data .= '<td>编号</td>';
        $data .= '<td>客户</td>';
        $data .= '<td>联系人</td>';
        $data .= '<td>应收</td>';
        $data .= '<td>扣款</td>';
        $data .= '<td>实收</td>';
        $data .= '<td>优惠</td>';
        $data .= '<td>欠款</td>';
        $data .= '<td>店铺</td>';
        $data .= '<td>操作员</td>';
        $data .= '<td>时间</td>';
        $data .= '<td>备注</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['sn']}</td>";
            $data .= "<td>{$val['customer_sn']}</td>";
            $data .= "<td>{$val['customer_name']}</td>";
            $data .= "<td>{$val['customer_contact']}</td>";
            $data .= "<td>{$val['ysje']}</td>";
            $data .= "<td>{$val['khyc']}</td>";
            $data .= "<td>{$val['ssje']}</td>";
            $data .= "<td>{$val['yhje']}</td>";
            $data .= "<td>{$val['qkje']}</td>";
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['user_name']}</td>";
            $data .= '<td>'.date('Y-m-d H:i:s',$val['create_time']).'</td>';
            $data .= "<td>{$val['memo']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'批发销售');
    }
}