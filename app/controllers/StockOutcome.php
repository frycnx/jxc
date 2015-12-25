<?php
class StockOutcome extends Acl{
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

        $goods_mod = m('StockOutcome');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

    public function add(){
        $sn = get('sn');
        if(empty($sn)) {
            $row = array(
                'sn' => m('StockOutcome')->getSn(),
                'shop_id' => session('shop_id'),
                'user_name' => session('user_name'),
                'status' => '0'
            );
        } else {
            $row = m('StockOutcome')->getRowBySn($sn);
        }
        $this->view()
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
            ->display();
    }

    public function save(){
        //保存单据
        $mod = m('StockOutcome');
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
        $r = m('StockOutcomeGoods')->changeStock($row);
        if( !$r ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        $mod->commit();
        $this->success('保存成功！');
    }

    public function del(){
        $id = get('id');
        $goods_mod = m('StockOutcome');
        $goods_mod->startTrans();
        $r = $goods_mod->delete("id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $r = m('StockOutcomeGoods')->delete("outcome_id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $goods_mod->commit();
        $this->success('删除成功！');
    }

    public function getId($status,$row=array()){
        $data = array();
        $data['sn'] = post('sn');
        $data['type'] = post('type');
        $data['user_id'] = session('user_id');
        $data['user_name'] = session('user_name');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = m('Shop')->getCache($data['shop_id']);
        $data['status'] = $status;
        $data['memo'] = post('memo');
        return m('StockOutcome')->add($data,$row);
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
            $data = m('StockOutcomeGoods')->getList("outcome_sn='{$sn}'");
        echo json_encode($data);
    }

    public function addGoods(){
        //增加商品
        $row = m('StockOutcome')->getRowBySn(post('sn'));
        $data = array();
        $data['outcome_id'] = $this->getId('0',$row);
        $data['outcome_sn'] = post('sn');
        $data['goods_id'] = post('goods_id');
        $data['discount'] = post('discount');
        $data['amount'] = post('amount');
        $data['price'] = post('price');
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        $r = m('StockOutcomeGoods')->add($data);
        if($r === false) {
            $this->error(m('StockOutcomeGoods')->error());
        } else {
            $this->success('增加成功！');
        }
    }

    public function editGoods(){
        //编辑商品
        $id = post('id');
        $data = array();        
        $data['amount'] = post('amount');
        $data['discount'] = post('discount');
        $data['price'] = post('price');
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        $r = m('StockOutcomeGoods')->update($data, "id='{$id}'");
        if($r === false) {
            $this->error(m('StockOutcomeGoods')->error());
        } else {
            $this->success('编辑成功！');
        }
    }

    public function delGoods()
    {
        $id = get('id');
        $r = m('StockOutcomeGoods')->delete("id='{$id}'");
        if($r === false) {
            $this->error(m('StockOutcomeGoods')->error());
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
        echo outXls($data,'直接出库');
    }
}