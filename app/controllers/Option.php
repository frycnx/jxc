<?php
class Option extends Acl{
	public function __construct(){
		parent::__construct();
	}

	public function index()
    {
        if(isPost()) {
            return $this->_index();
        }
        $arr = m('Option')->getList();
        $opt = array();
        foreach($arr as $val) {
            $opt[$val['key']] = $val['val'];
        }
        $this->view()
            ->assign('title', '其他设置')
            ->assign('opt', $opt)
            ->display('option_form');
	}

    private function _index()
    {
        $this->verifyForm();
        $data = array();
        $opt_mod = m('Option');
        $opt_mod->startTrans();
        foreach(post('opt') as $key => $val) {
            $r = $opt_mod->update(array('val' => $val), "`key`='{$key}'");
            if($r === false) {
                $opt_mod->rollBack();
                $this->error($opt_mod->error());
            }
        }
        $opt_mod->commit();
        $opt_mod->clearCache();
        $this->success('保存成功！');
    }
}