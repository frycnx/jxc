<?php
class MemberExchange extends Acl{
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
        $this->view()
            ->assign('my_shop', getMyShop())
            ->assign('member_level', getMemberLevel())
            ->display();
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
        $level_id = get('level_id');
        if(!empty($level_id)) { 
            $where[] = "level_id ='{$level_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(member_card like '%{$kw}%' OR 
						member_name like '%{$kw}%' OR 
						member_pinyin like '%{$kw}%')";
        }
        $start = get('start_time');
        if(!empty($start)) {
            $where[] = 'create_time>'.strtotime($start);
        }
        $end = get('end_time');
        if(!empty($end)) {
            $where[] = 'create_time<'.(strtotime($end)+24*3600);
        }

        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('MemberExchange');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

    public function member()
    {
        if(isAjaxTable()) {
            return $this->_member();
        }
        $this->view()
            ->assign('my_shop', getMyShop())
            ->assign('member_level', getMemberLevel())
            ->display();
    }

    private function _member()
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
        $data = array();
        $data['data'] = $member_mod->getList($where, $order, page());
        $data['count'] = $member_mod->getCount($where);
        echo json_encode($data);
    }

    public function add() 
    {
        if(isPost()) {
            return $this->_add();
        }
        $row = m('Member')->getRowById(get('id'));
        $this->view()
			->assign('title','积分兑换')
            ->assign('action', url('MemberExchange','add'))
			->assign('row', $row)
			->display('memberexchange_form');
    }

	private function _add()
	{
        $this->verifyForm();
        $member_mod = m('Member');
        $row = $member_mod->getRowById(post('id'));
        $data = array();
        $data['member_id'] = $row['id'];
        $data['member_card'] = $row['card'];
        $data['member_name'] = $row['name'];
        $data['member_pinyin'] = $row['pinyin'];
        $data['level_id'] = $row['level_id'];
        $data['level_name'] = $row['level_name'];
		$data['level_discount'] = $row['level_discount'];
        $data['user_id'] = session('user_id');
        $data['user_name'] = session('user_name');
		$data['shop_id'] = $row['shop_id'];
		$data['shop_name'] = $row['shop_name'];
        $data['consume'] = $row['consume'];
        $data['point'] = post('point');
        $data['current_point'] = $row['point']-$data['point'];
        $data['memo'] = post('memo');
        $data['create_time'] = time();
        
        $mExchange_mod = m('MemberExchange');        
        $mExchange_mod->startTrans();
        $r = $mExchange_mod->insert($data);
        if($r === false) {
            $mExchange_mod->rollback();
			$this->error($mExchange_mod->error());
        }
        $r = $member_mod->changeMoney("id={$data['member_id']}",array(
						'point' => 0-$data['point']
					));
        if($r === false) {
            $mExchange_mod->rollback();
			$this->error($mExchange_mod->error());
        }
		$mExchange_mod->commit();
		$this->success('保存成功！');
	}

    public function import()
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
            $where[] = "(member_card like '%{$kw}%' OR 
                        member_name like '%{$kw}%' OR 
                        member_pinyin like '%{$kw}%')";
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

        $goods_mod = m('MemberExchange');
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>卡号</td>';
		$data .= '<td>姓名</td>';
        $data .= '<td>级别</td>';
        $data .= '<td>折扣</td>';
        $data .= '<td>店铺</td>';
        $data .= '<td>当前消费</td>';
        $data .= '<td>兑换积分</td>';
        $data .= '<td>剩余积分</td>';
        $data .= '<td>操作员</td>';
        $data .= '<td>备注</td>';        
        $data .= '<td>时间</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['member_card']}</td>";
            $data .= "<td>{$val['member_name']}</td>";
            $data .= "<td>{$val['level_name']}</td>";
            $data .= "<td>{$val['level_discount']}</td>";
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['consume']}</td>";
            $data .= "<td>{$val['point']}</td>";
            $data .= "<td>{$val['current_point']}</td>";            
            $data .= "<td>{$val['user_name']}</td>";
            $data .= "<td>{$val['memo']}</td>";
            $data .= '<td>'.date('Y-m-d H:i:s',$val['create_time']).'</td>';
            $data .= '</tr>';
        }
        echo outXls($data,'积分兑换');
    }
}