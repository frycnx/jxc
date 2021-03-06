<?php
class GoodsBind extends Acl{
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
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id = '{$cate_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(goods_id LIKE '%{$kw}%' OR goods_name LIKE '%{$kw}%' OR goods_pinyin LIKE '%{$kw}%' OR goods_barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('GoodsBind');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

    public function getId($row=array(),$status=0)
    {
        $data = array();
        $data['sn'] = post('sn');
        $data['user_id'] = session('user_id');
        $data['user_name'] = session('user_name');
        $data['shop_id'] = post('shop_id');
        $data['shop_name'] = m('Shop')->getCache($data['shop_id']);
        $data['goods_id'] = post('goods_id');
        $data['goods_amount'] = post('goods_amount');
        $data['status'] = $status;
        $data['memo'] = post('memo');
        return m('GoodsBind')->add($data,$row);
    }

    public function add(){
        if(isPost()) {
            return $this->_add();
        }
        $sn = get('sn');
        if($sn) {
            $row = m('GoodsBind')->getRowBySn($sn);
        } else {
            $row = array(
                'sn' => m('GoodsBind')->getSn(),
                'shop_id' => session('shop_id'),
                'user_name' => session('user_name'),
                'status' => '0'
            );
        }
        $this->view()
            ->assign('row', $row)
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
            ->display();
    }

    private function _add()
    {
        $row = m('GoodsBind')->getRowBySn(post('sn'));
        $r = $this->getId($row);
        if($r === false) {
            $this->error('保存失败！');
        } else {
            $this->success('保存成功！');
        }
    }

    public function save()
    {
        //保存单据
        $mod = m('GoodsBind');
        $mod->startTrans();
        $row = $mod->getRowBySn(post('sn'));
        if($row['status']) {
            $mod->rollBack();
            $this->error('单据已完成!');
        }
        $id = $this->getId($row,'1');
        if( !$id ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        //处理库存
        $r = m('GoodsBindGoods')->changeStock($row);
        if( !$r ) {
            $mod->rollBack();
            $this->error($mod->error());
        }
        $mod->commit();
        $this->success('保存成功！');
    }

    public function del()
    {
        $id = get('id');
        $goods_mod = m('GoodsBind');
        $goods_mod->startTrans();
        $r = $goods_mod->delete("id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $r = m('GoodsBindGoods')->delete("bind_id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $goods_mod->commit();
        $this->success('删除成功！');
    }

    public function getGoods()
    {
        $sn = get('sn');        
        if($sn) {
            $arr = m('GoodsBindGoods')->getList("bind_sn='{$sn}'");
            echo json_encode($arr);
            return;
        }
        echo json_encode(array());
    }

    public function addGoods()
    {
        //增加商品
        $row = m('GoodsBind')->getRowBySn(post('sn'));
        $data = array();
        $data['bind_id'] = $this->getId($row);
        $data['bind_sn'] = post('sn');
        $data['goods_id'] = post('id');
        $data['discount'] = post('discount');
        $data['amount'] = post('amount');
        $data['price'] = post('price');
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        $r = m('GoodsBindGoods')->add($data);
        if($r === false) {
            $this->error(m('GoodsBindGoods')->error());
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
        $r = m('GoodsBindGoods')->update($data, "id='{$id}'");
        if($r === false) {
            $this->error(m('GoodsBindGoods')->error());
        } else {
            $this->success('增加成功！');
        }
    }

    public function delGoods()
    {
        $id = get('id');
        $r = m('GoodsBindGoods')->delete("id={$id}");
        if($r === false) {
            $this->error(m('GoodsBindGoods')->error());
        } else {
            $this->success('删除成功！');
        }
    }
}