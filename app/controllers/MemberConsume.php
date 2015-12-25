<?php
class MemberConsume extends Acl{
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
            $where[] = "(member_card like '%{$kw}%' OR member_name like '%{$kw}%' OR member_pinyin like '%{$kw}%' OR goods_name like '%{$kw}%' OR goods_pinyin like '%{$kw}%')";
        }
        $start = get('start');
        if(!empty($start)) {
            $time = strtotime($start);
            $where[] = "create_time > {$time}";
        }
        $end = get('end');
        if(!empty($end)) {
            $time = strtotime($end)+24*3600;
            $where[] = "create_time < {$time}";
        }

        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = $this->model('MemberConsume');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

}