<?php
class CustomerDebt extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()->display();
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
            $map = '';
 			$map.= "(name like '%".$kw."%' OR ";
 			$map.= "sex like '%".$kw."%' OR ";
 			$map.= "addr like '%".$kw."%' OR ";
 			$map.= "birth like '%".$kw."%' OR ";
 			$map.= "pinyin like '%".$kw."%' OR ";
 			$map.= "phone like '%".$kw."%' OR ";
			$map.= "card like '%".$kw."%' OR ";
 			$map.= "memo like '%".$kw."%')";
            $where[] = $map;
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = $this->model('Customer');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }
}