<?php
class Goods extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()
            ->assign('category', getCategory())
            ->display();
	}

    private function _index(){
        $where = array();
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id = '{$cate_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sku LIKE '%{$kw}%' OR name LIKE '%{$kw}%' OR pinyin LIKE '%{$kw}%' OR barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Goods');
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
        $my_shops = getMyShop();
        $stock = array();
        foreach($my_shops as $key=>$val) {
            $tmp = array();
            $tmp['shop_id'] = $key;
            $tmp['shop_name'] = $val;
            $tmp['price_sell'] = '';
            $stock[] = $tmp;
        }
        $row = array(
            'sku' => m('Goods')->getNewSku(option('goods_unit')),
            'stock' => $stock,
            'is_stock' => '1',
            'status' => '1'
        );
        $this->view()
            ->assign('title', '新增商品')
            ->assign('action', url('Goods','add'))
            ->assign('row', $row)
            ->assign('category', getCategory())
            ->display('goods_form');
	}

    private function _add()
    {
        $this->verifyForm();
        $data = array();
        $data['sku'] = post('sku');
        $data['name'] = post('name');
        $data['spec'] = post('spec');
        $data['origin'] = post('origin');
        $data['unit'] = post('unit');
        $data['pinyin'] = post('pinyin');
        $data['barcode'] = post('barcode');  
        $data['cate_id'] = post('cate_id');
        $data['cate_name'] = getCategory($data['cate_id']);
        $data['status'] = post('status');
        $data['memo'] = post('memo');
		
        $goods_mod = m('Goods');
        $goods_mod->startTrans();
        if(!$goods_mod->hasUnqiueName($data['name'])) {
            $goods_mod->rollBack();
            $this->error('商品名重复！');
        }
        $id = $goods_mod->insert($data);
        if($id === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        
        $stock = array();
        $prices = post('price_sell');
        foreach($prices as $key => $val) {
            $tmp = array();
            $tmp['shop_id'] = $key;
            $tmp['shop_name'] = getShop($key);
            $tmp['goods_id'] = $id;
            $tmp['goods_sku'] = $data['sku'];
            $tmp['price_sell'] = $val;
            $stock[] = $tmp;
        }
        $r = m('Stock')->insertAll($stock);
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $goods_mod->commit();
        $this->success('保存成功！');
    }

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $goods_id = get('id');
        $row = m('Goods')->getRowById($goods_id);
        //获取库存价格
        $price = m('Stock')->getGoodsStock($goods_id);
        $my_shops = getMyShop();
        $stock = array();
        foreach($my_shops as $key=>$val) {
            $tmp = array();
            $tmp['shop_id'] = $key;
            $tmp['shop_name'] = $val;
            if($price[$key]) {
                $tmp['price_sell'] = $price[$key]['price_sell'];
            } else {
                $tmp['price_sell'] = '';
            }
            $stock[] = $tmp;
        }
        $row['stock'] = $stock;
        $this->view()
            ->assign('title','编辑商品')
            ->assign('action', url('Goods','edit'))
            ->assign('row', $row)
            ->assign('category', getCategory())
            ->display('goods_form');
	}

    private function _edit()
    {
        $this->verifyForm();
        $data = array();
        $data['sku'] = post('sku');
        $data['name'] = post('name');
        $data['spec'] = post('spec');
        $data['origin'] = post('origin');
        $data['unit'] = post('unit');
        $data['pinyin'] = post('pinyin');
        $data['barcode'] = post('barcode');  
        $data['cate_id'] = post('cate_id');
        $data['cate_name'] = getCategory($data['cate_id']);
        $data['status'] = post('status');
        $data['memo'] = post('memo');
		
        $goods_id = post('id');
        $goods_mod = m('Goods');
        $goods_mod->startTrans();
        $r = $goods_mod->update($data, 'id=' . $goods_id);
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        
        $stock = array();
        $prices = post('price_sell');
        foreach($prices as $key => $val) {
            $tmp = array();
            $tmp['shop_id'] = $key;
            $tmp['shop_name'] = getShop($key);
            $tmp['goods_id'] = $goods_id;
            $tmp['goods_sku'] = $data['sku'];
            $tmp['price_sell'] = $val;
            $stock[] = $tmp;
        }
        $r = m('Stock')->editGoodsStock($stock);
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $goods_mod->commit();
        $this->success('保存成功！');
    }

    public function del()
    {
        $id = get('id');
        $goods_mod = m('Goods');
        $goods_mod->startTrans();
        $r = $goods_mod->delete("id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $r = m('Stock')->delete("goods_id={$id}");
        if($r === false) {
            $goods_mod->rollBack();
            $this->error($goods_mod->error());
        }
        $goods_mod->commit();
        $this->success('删除成功！');
    }

    public function import()
    {
        $where = array();
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sku LIKE '%{$kw}%' OR name LIKE '%{$kw}%' OR pinyin LIKE '%{$kw}%' OR barcode LIKE '%{$kw}%')";
        }
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id = '{$cate_id}'";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }
        $goods_mod = m('Goods');
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>SKU</td>';
		$data .= '<td>商品</td>';
        $data .= '<td>规格</td>';
        $data .= '<td>产地</td>';
        $data .= '<td>单位</td>';
        $data .= '<td>条码</td>';
        $data .= '<td>分类</td>';
        $data .= '<td>备注</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['sku']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['spec']}</td>";
            $data .= "<td>{$val['origin']}</td>";
            $data .= "<td>{$val['unit']}</td>";
            $data .= "<td>{$val['barcode']}</td>";
            $data .= "<td>{$val['cate_name']}</td>";
            $data .= "<td>{$val['memo']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'商品');
    }
}