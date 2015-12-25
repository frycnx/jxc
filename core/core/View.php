<?php

/**
 * 视图类
 * @author frycn
 *
 */
class View
{

    /**
     * 模板变量
     */
    private $vars = array();

    /**
     * 变量分配
     * 
     * @param 变量名 $k            
     * @param 变量值 $v            
     */
    public function assign ($k, $v)
    {
        $this->vars[$k] = $v;
        return $this;
    }

    /**
     * 模板渲染载入
     * 
     * @param 模板名 $file            
     */
    public function display ($file = '')
    {
        global $_G, $ERROR;
        extract($this->vars, EXTR_OVERWRITE);
        if (empty($file)) {
            $file = strtolower($_G['app']) . '_' . strtolower($_G['act']);
        }
        $tpl = $_G['views_path'] . $file . '.php';
        if (file_exists($tpl)) {
            include $tpl;
        } else {
            $ERROR->show_error('View Not Found');
        }
        return $this;
    }
}