<?php
class Role extends Acl{
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
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(name LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Role');
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
        $row = array(
                'status' => '1',
                'rights' => array(
                    'shops'=>array(session('shop_id')),
                    'rights'=>array()
                )
            );
        $this->view()
            ->assign('title', '新增角色')
            ->assign('action', url('Role','edit'))
            ->assign('row', $row)
            ->assign('shop', getShop())
            ->display('role_form');
	}

    private function _add()
    {
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
        $data['rights'] = serialize(array('shops'=>post('shops'),'rights'=>post('rights')));
		$data['status'] = post('status');

        $shop_mod = m('Role');
        if(!$shop_mod->hasUnqiueName($data['name'])) {
            $this->error('权限名重复！');
        }
        $r = $shop_mod->insert($data);            
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            m('Role')->clearCache();
            $this->success('保存成功！');
        }
    }

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('Role')->getRowById(get('id'));
        if($row['rights']) {
            $row['rights'] = unserialize($row['rights']);
        } else {
            $row['rights'] = array('shops'=>array(),'rights'=>array());
        }
        $this->view()
            ->assign('title','编辑角色')
            ->assign('action', url('Role','edit'))
            ->assign('row', $row)
            ->assign('shop', getShop())
            ->display('role_form');
	}

    private function _edit()
    {
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
        $data['rights'] = serialize(array('shops'=>post('shops'),'rights'=>post('rights')));
		$data['status'] = post('status');

        $shop_mod = m('Role');
        $r = $shop_mod->update($data, 'id=' . post('id'));
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            m('Role')->clearCache();
            $this->success('保存成功！');
        }
    }

    public function del()
    {
        $id = get('id');
        $r = m('Role')->delete("id='{$id}'");
        if($r === false) {
            $this->error(m('Role')->error());
        } else {
            m('Role')->clearCache();
            $this->success('删除成功！');
        }
    }

    public function import()
    {
        $where = array();
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(name LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Role');
        $data = array();
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>编号</td>';
        $data .= '<td>角色</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['id']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'角色');
    }
}