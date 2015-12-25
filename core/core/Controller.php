<?php

/**
 * @author frycn
 */
class Controller
{

    /**
     * 视图对象
     * 
     * @var View
     */
    private $view = null;

    /**
     * 模型对象
     * 
     * @var Model
     */
    private $models = array();

    /**
     * 构造函数
     */
	public function __construct()
	{}


    /**
     * 实例化模型对象
     * 
     * @param string $model            
     * @return Model|boolean
     */
    public function model ($model)
    {
        return m($model);
    }

    /**
     * 实例化视图对象
     */
    public function view ()
    {
        if ($this->view == null) {
            $this->view = new View();
        }
        return $this->view;
    }

    public function message ($info, $state=1, $url='', $data=array()){
        if(isAjax()) {
            $result  =  array();
            $result['state']  =  $state;
            $result['info'] =  $info;
            $result['url'] = $url;
            $result['data'] = $data;
            header('Content-Type:text/html; charset=utf-8');
            exit(json_encode($result));
        }
        if(empty($url)&&isset($_SERVER["HTTP_REFERER"])){
            $url = $_SERVER["HTTP_REFERER"];
        }
        $this->view();
        $this->view->assign('time',3);
        $this->view->assign('url',$url);
        $this->view->assign('state',$state);
        $this->view->assign('info',$info);
        $this->view->display('_message');
        exit;
    }

    public function error($info, $url='', $data = array()){
        $this->message($info, 0, $url, $data);
    }

    public function success($info, $url='', $data = array()){
        $this->message($info, 1, $url, $data);
    }
}
