<?php
class Stock extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
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

        $goods_mod = m('Stock');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        $data['sum'] = $goods_mod->getSum($where);
        echo json_encode($data);
    }

    public function detail()
    {
        if(isAjaxTable()) {
            return $this->_detail();
        }
        $this->view()
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
            ->display();
    }

    private function _detail(){
        $where = array();
        $shop_ids = getMyShopId();
        $from_shop_id = get('from_shop_id');
        if($from_shop_id&&in_array($from_shop_id,$shop_ids)) { 
            $where[] = "from_shop_id ='{$from_shop_id}'";
        } else {
            $where[] = 'from_shop_id in('.implode(',',$shop_ids).')';
        }
        $to_shop_id = get('to_shop_id');
        if($to_shop_id&&in_array($to_shop_id,$shop_ids)) { 
            $where[] = "to_shop_id ='{$to_shop_id}'";
        } else {
            $where[] = 'to_shop_id in('.implode(',',$shop_ids).')';
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sn LIKE '%{$kw}%' OR user_name LIKE '%{$kw}%' OR memo LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('StockAccount');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

    public function export()
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

        $goods_mod = m('Stock');
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
        $data .= '<tr>';
        $data .= '<td>SKU</td>';
        $data .= '<td>商品</td>';
        $data .= '<td>规格</td>';
        $data .= '<td>单位</td>';
        $data .= '<td>分类</td>';
        $data .= '<td>店铺</td>';
        $data .= '<td>库存</td>';
        $data .= '<td>成本价</td>';
        $data .= '<td>成本总额</td>';
        $data .= '<td>销量</td>';
        $data .= '<td>售价</td>';
        $data .= '<td>销售总额</td>';
        $data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['sku']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['spec']}</td>";
            $data .= "<td>{$val['unit']}</td>";
            $data .= "<td>{$val['cate_name']}</td>";
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['stock_num']}</td>";
            $data .= "<td>{$val['price_cost']}</td>";
            $data .= "<td>{$val['total_cost']}</td>";
            $data .= "<td>{$val['sale_num']}</td>";
            $data .= "<td>{$val['price_sell']}</td>";
            $data .= "<td>{$val['total_sell']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'库存');
    }
}
