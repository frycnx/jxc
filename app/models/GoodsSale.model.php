<?php
class GoodsSaleModel extends Model
{
    public function __construct()
    {
        $this->table('goods_sale');
    }

    public function getRowById($id)
    {
        return $this->row("SELECT * FROM {$this->table} WHERE id='{$id}'");
    }

    public function hasUnqiue($goods_id,$shop_id)
    {
        $arr = $this->select("SELECT id,status FROM {$this->table} WHERE shop_id={$shop_id} AND goods_id='{$goods_id}'");
        $is = array();
        foreach($arr as $val) {
            if($val['status']) {
                $is[] = $val['id'];
            }
        }
        return count($is) < 1;
    }

    public function getList($where='', $order='', $limit='')
    {
        $s = '';
        if(!empty($where)) {
            $s .= ' WHERE '.(is_array($where)? implode(' AND ', $where): $where);
        }
		if(!empty($order)) {
            $s .= ' ORDER BY ' . (is_array($order)? implode(',', $order): $order);
		}
        if(!empty($limit)) {
            $s .= ' LIMIT ' . $limit;
        }
        return $this->select("SELECT gs.*,g.sku,g.name,g.spec,g.origin,g.unit,g.pinyin,g.barcode,g.cate_id,g.cate_name FROM {$this->table} gs LEFT JOIN {$this->prefix}goods g ON gs.goods_id=g.id {$s}");
    }

    public function getCount($where='')
    {
        $s = '';
        if(!empty($where)) {
            $s = ' WHERE '.(is_array($where)? implode(' AND ', $where): $where);
        }
        return $this->one("SELECT count(*) as count FROM {$this->table} gs LEFT JOIN {$this->prefix}goods g ON gs.goods_id=g.id {$s}");
    }

}