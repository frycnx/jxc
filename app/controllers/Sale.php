<?php
class Sale extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->view()->display();
	}

    public function getNoCheck()
    {
        $where = array();
        $shop_id = get('shop_id');
        if(!empty($shop_id)) {
            $where[] = "shop_id={$shop_id}";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sn LIKE '%{$kw}%' OR 
                        user_name LIKE '%{$kw}%' OR 
                        staff_name LIKE '%{$kw}%' OR 
                        member_name LIKE '%{$kw}%')";
        }
        $where[] = "status=0";
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Sale');
        $data = $goods_mod->getList($where, $order);
        echo json_encode($data);
    }

    public function creatrSN(){
        echo m('Sale')->getSn();
    }

    private function _getId($arr=array(),$status='0'){
        $data = array();
        $data['sn'] = post('sn');
        $data['user_id'] = session('user_id');
        $data['user_name'] = session('user_name');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = getShop($data['shop_id']);
        $data['staff_id'] = post('staff_id');
        $data['staff_name'] = post('staff_name');
        $data['member_id'] = post('member_id');
        $data['member_card'] = post('member_card');
        $data['member_name'] = post('member_name');
        $data['member_level'] = post('member_level');
        $data['member_point'] = post('member_point');
        $data['skfs'] = post('skfs');
        $data['ysje'] = post('ysje');
        $data['ssje'] = post('ssje');
        $data['yhje'] = post('yhje');
        $data['zlje'] = post('zlje');
        $data['status'] = $status;
        return m('Sale')->add($data,$arr);
    }

    public function addMember()
    {
        $mod = m('Sale');
        $mod->startTrans();
        $row = $mod->getRowBySn(post('sn'));
        if($row['status']) {
            $this->error('单据已完成!');
        }
        $id = $this->_getId($row);
        if( !$id ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        $member = m('Member')->getRowById(post('member_id'));
        $r = m('SaleGoods')->memberGoods($row, $member);
        if( !$r ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        $mod->commit();
        $this->success('保存成功！');
    }

    public function save(){
        //保存单据
        $mod = m('Sale');
        $mod->startTrans();
        $row = $mod->getRowBySn(post('sn'));
        if($row['status']) {
            $mod->rollBack();
            $this->success('单据已完成!');
        }
        $id = $this->_getId($row,'1');
        if( !$id ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        $goods_list = m('SaleGoods')->getList("sale_id={$row['id']}");
        if(count($goods_list)<1) {
            $mod->rollBack();
            $this->error('商品为空!');
        }
        //处理库存
        $r = m('SaleGoods')->changeStock($row, $goods_list);
        if( !$r ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        //处理积分
        if($row['member_id']) {
            $ss = post('ssje');
            $mp = option('member_point');
            $ssje = is_numeric($ss)? (float)$ss: 0;
            $mpfs = is_numeric($mp)? (float)$mp: 0;
            $r = m('Member')->changeMoney("id={$row['member_id']}",array(
                            'consume' => $ssje,
                            'point' => floor($ssje/$mpfs),
                        ));
            if( !$r ) {
                $mod->rollBack();
                $this->error($mod->error());
            }
        }
        $mod->commit();
        $this->success('保存成功！');
    }

    public function del(){
        $id = get('id');
        $goods_mod = m('Sale');
        $goods_mod->startTrans();
        $r = $goods_mod->delete("id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $r = m('SaleGoods')->delete("outcome_id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $goods_mod->commit();
        $this->success('删除成功！');
    }

    public function goods()
    {
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "s.shop_id ='{$shop_id}'";
        } else {
            $where[] = 's.shop_id in('.implode(',',$shop_ids).')';
		}
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "g.cate_id={$cate_id}";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(g.sku LIKE '%{$kw}%' OR 
                        g.name LIKE '%{$kw}%' OR 
                        g.pinyin LIKE '%{$kw}%' OR 
                        g.barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $arr = m('Sale')->getStock($where, $order, page());
        $member = m('Member')->getRowById(get('member_id'));
        $data = array();
        foreach($arr as $val) {
            $tmp = array();
            $tmp['id'] = $val['id'];
            $tmp['sku'] = $val['sku'];
            $tmp['name'] = $val['name'];
            $tmp['spec'] = $val['spec'];
            $tmp['stock_num'] = $val['stock_num'];
            $tmp['discount'] = '1';
            if($val['sale_time_type']=='a') {
                if(is_numeric($val['price_member'])&&isset($member['id'])) {
                    $tmp['price_sell'] = $val['price_member'];
                } else if(is_numeric($val['price_sale'])) {
                    $tmp['price_sell'] = $val['price_sale'];
                }
            }elseif($val['sale_time_type']=='w') {
                if(in_array(date('w'),explode(',',$val['sale_time']))) {
                    if(is_numeric($val['price_member'])&&isset($member['id'])) {
                        $tmp['price_sell'] = $val['price_member'];
                    } else if(is_numeric($val['price_sale'])) {
                        $tmp['price_sell'] = $val['price_sale'];
                    }
                }
            }elseif($val['sale_time_type']=='t') {
                $time = time();
                $arr = explode(',',$val['sale_time']);
                $check = is_numeric($arr[0]) && $arr[0]>0 && $time>$arr[0];
                $check = (is_numeric($arr[1]) && $arr[0]>0)? ($check&&$time<$arr[1]): $check;
                if( $check ) {
                    if(is_numeric($val['price_member'])&&isset($member['id'])) {
                        $tmp['price_sell'] = $val['price_member'];
                    } else if(is_numeric($val['price_sale'])) {
                        $tmp['price_sell'] = $val['price_sale'];
                    }
                }
            }
            if(!isset($tmp['price_sell'])) {
                $tmp['price_sell'] = $val['price_sell'];
                if(isset($member['id'])) {
                    $tmp['discount'] = $member['level_discount'];
                }
            }
            $data[] = $tmp;
        }
        echo json_encode($data);
    }

    public function member()
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
        $data = $member_mod->getList($where, $order, page());
        echo json_encode($data);
    }
    
    public function staff()
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
            $where[] = "(name LIKE '%{$kw}%' OR 
                        email LIKE '%{$kw}%' OR 
                        phone LIKE '%{$kw}%' OR 
                        join_time LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Staff');
        $data = $goods_mod->getList($where, $order, page());
        echo json_encode($data);
    }

    public function getGoods()
    {
        $sn = get('sn');        
        if(empty($sn)) {
            echo json_encode(array());
        }
        $data = m('SaleGoods')->getList("sale_sn='{$sn}'");
        echo json_encode($data);
    }

    public function addGoods(){
        //增加商品
        $sn = post('sn');
        $row = m('Sale')->getRowBySn($sn);
        $data = array();
        $data['sale_id'] = $this->_getId($row);
        $data['sale_sn'] = $sn;
        $data['goods_id'] = post('goods_id');
        $data['discount'] = post('discount');
        $data['amount'] = post('amount');
        $data['price'] = post('price');
        $r = m('SaleGoods')->add($data, $row['shop_id']);
        if($r === false) {
            $this->error(m('SaleGoods')->error());
        }
        $this->success('增加成功！');
    }

    public function editGoods(){
        //编辑商品
        $id = post('id');
        $data = array();        
        $data['amount'] = post('amount');
        $data['discount'] = post('discount');
        $data['price'] = post('price');
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        $r = m('SaleGoods')->update($data, "id='{$id}'");
        if($r === false) {
            $this->error(m('SaleGoods')->error());
        }
        $this->success('修改成功！');
    }

    public function delGoods()
    {
        $id = get('id');
        $r = m('SaleGoods')->delete("id='{$id}'");
        if($r === false) {
            $this->error(m('SaleGoods')->error());
        }
        $this->success('删除成功！');
    }
}