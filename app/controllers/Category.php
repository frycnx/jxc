<?php
class Category extends Acl 
{

	public function __construct()
    {
		parent::__construct ();
	}

	public function index()
    {
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()->display();
	}

    private function _index()
    {
        $where = '';
        $kw = get('kw');
        if(!empty($kw)) {
            $where = "name LIKE '%{$kw}%'";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $cate_mod = m('Category');
        $data = array();
        $data['data'] = $cate_mod->getList($where, $order, page());
        $data['count'] = $cate_mod->getCount($where);
        echo json_encode($data);
    }

	public function add()
    {
        if(isPost()) {
            return $this->_add();
        }
        $row = array(
            'name' => '',
            'status' => '1',
        );
        $this->view()
            ->assign('title', '新增分类')
            ->assign('action', url('Category','add'))
            ->assign('row', $row)
            ->display('category_form');
	}

    private function _add()
    {
        $data = array();
        $data['name'] = post('name');
        $data['pid'] = post('pid');
        $data['status'] = post('status');
        $cate_mod = m('Category');
        if(!$cate_mod->hasUnqiueName($data['name'])) {
            $this->error('分类名已存在！');
        }
        $r = $cate_mod->insert($data);            
        if($r === false) {
            $this->error($cate_mod->error());
        } else {
            $cate_mod->clearCache();
            $this->success('保存成功！');
        }
    }

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('Category')->getRowById(get('id'));
        $this->view()
            ->assign('title','编辑分类')
            ->assign('action', url('Category','edit'))
            ->assign('row', $row)
            ->display('category_form');
	}

    private function _edit()
    {
        $data = array();
        $data['name'] = post('name');
        $data['pid'] = post('pid');
        $data['status'] = post('status');
        $cate_mod = m('Category');
		$id = post('id');
        if(empty($id)) {        
            $this->error('未知分类！');
        }
        $r = $cate_mod->update($data, "id={$id}");
        if($r === false) {
            $this->error($cate_mod->error());
        } else {
            $cate_mod->clearCache();
            $this->success('保存成功！');
        }
    }

    public function del()
    {
        $id = get('id');
        $cate_mod = m('Category');
        $r = $cate_mod->delete("id={$id}");
        if($r === false) {
            $this->error($cate_mod->error());
        } else {
            $cate_mod->clearCache();
            $this->success('删除成功！');
        }
    }

    public function import()
    {
        $where = '';
        $kw = get('kw');
        if(!empty($kw)) {
            $where = "name LIKE '%{$kw}%'";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $cate_mod = m('Category');
        $arr = $cate_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>编号</td>';
		$data .= '<td>名称</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['id']}</td>";
            $data .= "<td>{$val['name']}</td>";
            $data .= '</tr>';
        }
        echo outXls($data,'分类');
    }
}