<?php
class Shop extends Acl{
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
        $name = get('name');
        if(!empty($name)) {
            $where[] = "(name LIKE '%{$name}%' OR pinyin LIKE '%{$name}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Shop');
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
        $this->view()
            ->assign('title', '新增分店')
            ->assign('action', url('Shop','add'))
            ->assign('row', array('status' => '1'))
            ->display('shop_form');
	}

    private function _add()
    {
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
        $data['pinyin'] = getPinYin($data['name']);
        $data['status'] = post('status');

        $shop_mod = m('Shop');
        if(!$shop_mod->hasUnqiueName($data['name'])) {
            $this->error('分店名重复！');
        }
        $r = $shop_mod->insert($data);
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            $shop_mod->clearCache();
            $this->success('保存成功！');
        }
    }

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('Shop')->getRowById(get('id'));
        $this->view()
            ->assign('title','编辑分店')
            ->assign('action', url('Shop','edit'))
            ->assign('row', $row)
            ->display('shop_form');
	}

    private function _edit()
    {
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
        $data['pinyin'] = getPinYin($data['name']);
        $data['status'] = post('status');

        $shop_mod = m('Shop');
        $r = $shop_mod->update($data, 'id=' . post('id'));
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            $shop_mod->clearCache();
            $this->success('保存成功！');
        }
    }

    public function del()
    {
        $id = get('id');
        $shop_mod = m('Shop');
        $r = $shop_mod->delete("id='{$id}'");
        if($r === false) {
            $this->error($shop_mod->error());
        } else {
            $shop_mod->clearCache();
            $this->success('删除成功！');
        }
    }

    public function import()
    {
        $where = array();
        $name = get('name');
        if(!empty($name)) {
            $where[] = "(name LIKE '%{$name}%' OR pinyin LIKE '%{$name}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Shop');
        $data = array();
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>编号</td>';
        $data .= '<td>店铺</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['id']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'店铺');
    }
}