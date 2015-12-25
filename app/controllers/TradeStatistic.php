<?php
class TradeStatistic extends Acl{
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
        $start_time = get('start_time');
        if(!empty($start_time)) {
            $where[] = 'create_time > ' . strtotime($start_time);
        }
        $end_time = get('end_time');
        if(!empty($end_time)) {
            $where[] = 'create_time < ' . strtotime($end_time);
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

        $goods_mod = m('Trade');
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
        $this->view()->display();
    }

    private function _detail(){
        $where = array();
        $trade_id = get('trade_id');
        if(!empty($trade_id)) {
            $where[] = "trade_id={$trade_id}";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }
        $goods_mod = m('TradeGoods');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        $data['sum'] = $goods_mod->getSum($where);
        echo json_encode($data);
    }

    public function export()
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
        $data .= '<td>����</td>';
		$data .= '<td>���</td>';
        $data .= '<td>�ͻ�</td>';
        $data .= '<td>��ϵ��</td>';
        $data .= '<td>Ӧ��</td>';
        $data .= '<td>�ۿ�</td>';
        $data .= '<td>ʵ��</td>';
        $data .= '<td>�Ż�</td>';
        $data .= '<td>Ƿ��</td>';
        $data .= '<td>����</td>';
        $data .= '<td>����Ա</td>';
        $data .= '<td>ʱ��</td>';
        $data .= '<td>��ע</td>';
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
        echo outXls($data,'����ͳ��');
    }
}