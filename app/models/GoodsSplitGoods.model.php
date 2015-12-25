<?php
class GoodsSplitGoodsModel extends Model
{
    public function __construct()
    {
        $this->table('goods_split_goods');
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
        return $this->select("SELECT * FROM {$this->table} {$s}");
    }

    public function getCount($where='')
    {
        $s = '';
        if(!empty($where)) {
            $s = ' WHERE '.(is_array($where)? implode(' AND ', $where): $where);
        }
        return $this->one("SELECT count(*) as count FROM {$this->table} {$s}");
    }

    public function add($data)
    {
        $goods = $this->row("SELECT * FROM {$this->prefix}goods WHERE id='{$data['goods_id']}'");
        if(empty($goods['id'])) {
            return false;
        }
        $data['goods_sku'] = $goods['sku'];
        $data['goods_name'] = $goods['name'];
        $data['goods_spec'] = $goods['spec'];
        $data['goods_unit'] = $goods['unit'];
        $data['goods_barcode'] = $goods['barcode'];
        $data['cate_id'] = $goods['cate_id'];
        return $this->insert($data);
    }

    public function changeStock($row)
    {        
        if(empty($row['goods_id'])) {
            return false;
        }
        $goods_list = $this->select("SELECT * FROM {$this->table} WHERE split_id={$row['id']}");
        if(count($goods_list)<1) {
            return false;
        }
        $goods_ids = array();
        foreach($goods_list as $goods) {
            $goods_ids[] = $goods['goods_id'];
        }
        $table = $this->prefix.'stock';
        $stock_list = $this->select("SELECT goods_id FROM {$table} WHERE shop_id={$row['shop_id']} AND goods_id in(".implode(',',$goods_ids).')','goods_id');
        $arr_sql = array();
        $arr_sql[] = "UPDATE {$table} SET stock_num=stock_num-{$row['goods_amount']},total_cost=(stock_num-{$row['goods_amount']})*price_cost WHERE shop_id={$row['shop_id']} AND goods_id={$row['goods_id']}";
        foreach($goods_list as $goods) {
            if(isset($stock_list[$goods['goods_id']])) {
                $arr_sql[] = "UPDATE {$table} SET stock_num=stock_num+{$goods['amount']},total_cost=(stock_num+{$goods['amount']})*price_cost WHERE shop_id={$row['shop_id']} AND goods_id={$goods['goods_id']}";
            } else {
                $arr_sql[] = "INSERT INTO {$table}(shop_id,shop_name,goods_id,goods_sku,stock_num,price_cost,total_cost) VALUES( {$row['shop_id']},'{$row['shop_name']}','{$goods['goods_id']}','{$goods['goods_sku']}',{$goods['amount']},0,0)";
            }
        }
        return $this->exec(implode(';',$arr_sql));
    }
}