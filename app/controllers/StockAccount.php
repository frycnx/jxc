<?php
class StockAccount extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index()
    {
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()->display();
	}

    private function _index(){
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

}