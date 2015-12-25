<?php
class MemberLevel extends Acl{
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

        $level_mod = m('MemberLevel');
        $data = array();
        $data['data'] = $level_mod->getList($where, $order, page());
        $data['count'] = $level_mod->getCount($where);
        echo json_encode($data);
    }

	public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $this->view()
			->assign('title', '新增级别')
            ->assign('action', url('MemberLevel','add'))
			->assign('row', array('status' => '1'))
			->display('memberlevel_form');
	}

	private function _add()
	{
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
		$data['discount'] = post('discount');
        $data['status'] = post('status');

        $level_mod = m('MemberLevel');
		if(!$level_mod->hasUnqiueName($data['name'])) {
			$this->error('级别名重复！');
		}
		$r = $level_mod->insert($data);  
        if($r === false) {
            $this->error($level_mod->error());
        } else {
            $level_mod->clearCache();
            $this->success('保存成功！');
        }
	}

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('MemberLevel')->getRowById(get('id'));
        $this->view()
			->assign('title','编辑级别')
            ->assign('action', url('MemberLevel','edit'))
			->assign('row', $row)
			->display('memberlevel_form');
	}

	private function _edit()
	{
        $this->verifyForm();
        $data = array();
        $data['name'] = post('name');
		$data['discount'] = post('discount');
        $data['status'] = post('status');

        $level_mod = m('MemberLevel');
		$r = $level_mod->update($data, 'id=' . post('id'));
        if($r === false) {
            $this->error($level_mod->error());
        } else {
            $level_mod->clearCache();
            $this->success('保存成功！');
        }
	}

    public function del()
    {
        $id = get('id');
        $level_mod = m('MemberLevel');
        $r = $level_mod->delete("id='{$id}'");
        if($r === false) {
            $this->error($level_mod->error());
        } else {
            $level_mod->clearCache();
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

        $level_mod = m('MemberLevel');
        $arr = $level_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>编号</td>';
		$data .= '<td>级别</td>';
        $data .= '<td>折扣</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['id']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= "<td>{$val['discount']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'会员折扣');
    }
}