<?php
class GoodsSale extends Acl{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
        if(isAjaxTable()) {
            return $this->_index();
        }
		$this->view()
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
            ->display();
	}

    private function _index(){
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id='{$cate_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sku LIKE '%{$kw}%' OR name LIKE '%{$kw}%' OR pinyin LIKE '%{$kw}%' OR barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('GoodsSale');
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
        $row = m('Goods')->getRowById(get('id'));
		$row['goods_id'] = $row['id'];
        $row['goods_sku'] = $row['sku'];
        $row['sale_time_type'] = 'a';
        $row['status'] = '1';
        $row['add'] = '1';

        //获取库存价格
        $stock = m('Stock')->getRowById(get('shop_id'),$row['goods_id']);
        $row['shop_id'] = $stock['shop_id'];
        $row['shop_name'] = $stock['shop_name'];
        $row['price_sell'] = $stock['price_sell'];
        $row['stock'] = $stock['stock'];

        $this->view()
            ->assign('title', '新增特价')
            ->assign('action', url('GoodsSale','add'))
            ->assign('row', $row)
            ->display('goodssale_form');
	}

    public function _add()
    {
        $this->verifyForm();
        $goods_id = post('goods_id');
        if(empty($goods_id)) {
            $this->error('产品不存在！');
        }
		$row = m('Goods')->getRowById($goods_id);
        $data = array();
        $data['goods_id'] = $row['id'];
        $data['goods_sku'] = $row['sku'];
		$data['shop_id'] = post('shop_id');
		$data['shop_name'] = post('shop_name');
        $data['price_sell'] = post('price_sell');
        $data['price_sale'] = post('price_sale');
        $data['price_member'] = post('price_member');
        $data['status'] = post('status');
        $data['sale_time_type'] = post('qx');
        if($data['sale_time_type'] == 't') {
            $riqi_start = post('riqi_start');
            $start = $riqi_start? strtotime($riqi_start): 0;
            $riqi_end = post('riqi_end');
            $end = $riqi_end? (strtotime($riqi_end) + 24*3600): 0;
            $data['sale_time'] = "{$start},{$end}";
        } else if ($data['sale_time_type'] == 'w') {
            $data['sale_time'] = implode(',',post('xiqi'));
        }

        $goods_mod = m('GoodsSale');
        if(!$goods_mod->hasUnqiue($data['goods_id'],$data['shop_id'])) {
            $this->error('相关特价已存在！');
        }
        $r = $goods_mod->insert($data);
        if($r === false) {
            $this->error($goods_mod->error());
        } else {
            $this->success('保存成功！');
        }
    }

	public function edit() 
    {
        if(isPost()) {
            return $this->_edit();
        }
        $row = m('GoodsSale')->getRowById(get('id'));
        $goods = m('Goods')->getRowById($row['goods_id']);
        $row['name'] = $goods['name'];
        $row['spec'] = $goods['spec'];
        $row['unit'] = $goods['unit'];
        $row['origin'] = $goods['origin'];
        $row['barcode'] = $goods['barcode'];
        $row['cate_id'] = $goods['cate_id'];
        $row['cate_name'] = $goods['cate_name'];
        $this->view()
            ->assign('title','编辑特价')
            ->assign('action', url('GoodsSale','edit'))
            ->assign('row', $row)
            ->display('goodssale_form');
	}

    public function _edit()
    {
        $this->verifyForm();
        $id = post('id');
        if(empty($id)) {
            $this->error('特价不存在！');
        }
        $data = array();
        $data['price_sell'] = post('price_sell');
        $data['price_sale'] = post('price_sale');
        $data['price_member'] = post('price_member');
        $data['status'] = post('status');
        $data['sale_time_type'] = post('qx');
        if($data['sale_time_type'] == 't') {
            $riqi_start = post('riqi_start');
            $start = $riqi_start? strtotime($riqi_start): 0;
            $riqi_end = post('riqi_end');
            $end = $riqi_end? (strtotime($riqi_end) + 24*3600): 0;
            $data['sale_time'] = "{$start},{$end}";
        } else if ($data['sale_time_type'] == 'w') {
            $data['sale_time'] = implode(',',post('xiqi'));
        }

        $goods_mod = m('GoodsSale');
        $r = $goods_mod->update($data, "id={$id}");
        if($r === false) {
            $this->error($goods_mod->error());
        } else {
            $this->success('保存成功！');
        }
    }

    public function del()
    {
        $id = get('id');
        $goods_mod = m('GoodsSale');
        $r = $goods_mod->delete("id={$id}");
        if($r === false) {
            $this->error($goods_mod->error());
        } else {
            $this->success('删除成功！');
        }
    }

    public function goods()
    {
        if(isAjaxTable()) {
            return $this->_goods();
        }
        $this->view()
            ->assign('my_shop', getMyShop())
            ->assign('category', getCategory())
            ->display('goodssale_goods');
    }

    private function _goods()
    {
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
        }
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id={$cate_id}";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(sku LIKE '%{$kw}%' OR 
                        name LIKE '%{$kw}%' OR 
                        pinyin LIKE '%{$kw}%' OR 
                        barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('Stock');
        $data = array();
        $data['data'] = $goods_mod->getList($where, $order, page());
        $data['count'] = $goods_mod->getCount($where);
        echo json_encode($data);
    }

    public function import()
    {
        $where = array();
        $shop_id = get('shop_id');	
        $shop_ids = getMyShopId();
        if($shop_id&&in_array($shop_id,$shop_ids)) { 
            $where[] = "shop_id ='{$shop_id}'";
        } else {
            $where[] = 'shop_id in('.implode(',',$shop_ids).')';
		}
        $cate_id = get('cate_id');
        if(!empty($cate_id)) {
            $where[] = "cate_id='{$cate_id}'";
        }
        $kw = get('kw');
        if(!empty($kw)) {
            $where[] = "(goods_id LIKE '%{$kw}%' OR goods_name LIKE '%{$kw}%' OR pinyin LIKE '%{$kw}%' OR barcode LIKE '%{$kw}%')";
        }
        $order = array();
        $sort = get('sort');
        if(is_array($sort)) {
            foreach ($sort as $key => $val) {
                $order[] = $key . ' ' . $val;
            }
        }

        $goods_mod = m('GoodsSale');
        $arr = $goods_mod->getList($where, $order);
        $data = '';
        $data .= '<table cellspacing="0" style="width:100%;border-collapse:collapse;">';
		$data .= '<tr>';
        $data .= '<td>SKU</td>';
		$data .= '<td>商品</td>';
        $data .= '<td>规格</td>';
        $data .= '<td>单位</td>';
        $data .= '<td>条码</td>';
        $data .= '<td>分类</td>';
        $data .= '<td>店铺</td>';
        $data .= '<td>售价</td>';
        $data .= '<td>特价</td>';
        $data .= '<td>会员价</td>';
        $data .= '<td>期限</td>';
		$data .= '</tr>';
        foreach($arr as $val) {
            $data .= '<tr>';
            $data .= "<td>{$val['goods_sku']}</td>";
            $data .= "<td>{$val['goods_name']}</td>";
            $data .= "<td>{$val['goods_spec']}</td>";
            $data .= "<td>{$val['goods_unit']}</td>";
            $data .= "<td>{$val['goods_barcode']}</td>";
            $data .= "<td>{$val['cate_name']}</td>";
            $data .= "<td>{$val['shop_name']}</td>";
            $data .= "<td>{$val['price_sell']}</td>";
            $data .= "<td>{$val['price_sale']}</td>";
            $data .= "<td>{$val['price_member']}</td>";
            if($val['sale_time_type']=='a'){
              $data .= '<td>无限期</td>';
            }else if($val['sale_time_type']=='t'){
              $ar = explode(',',$val['sale_time']);
              $data .= '<td>';
              if(isset($ar[0])) {
                $data .= date('Y-m-d',$ar[0]);
              } else {
                $data .= '-';
              }
              $data .= '至';
              if(isset($ar[1])) {
                $data .= date('Y-m-d',$ar[1]);
              } else {
                $data .= '-';
              }
              $data .= '</td>';
            }else if($val['sale_time_type']=='w'){
                $ar = explode(',',$val['sale_time']);
                $st = '';
                if(in_array('1',$ar)) {
                    $st .= ',周一';
                }
                if(in_array('2',$ar)) {
                    $st .= ',周二';
                }
                if(in_array('3',$ar)) {
                    $st .= ',周三';
                }
                if(in_array('4',$ar)) {
                    $st .= ',周四';
                }
                if(in_array('5',$ar)) {
                    $st .= ',周五';
                }
                if(in_array('6',$ar)) {
                    $st .= ',周六';
                }
                if(in_array('0',$ar)) {
                    $st .= ',周日';
                }
                $st = substr($st,1);
                $data .= "<td>{$st}</td>";
            }            
            $data .= '</tr>';
        }
        echo outXls($data,'特价');
    }
}