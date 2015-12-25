<?php
class StockWarecheckGoodsModel extends Model
{
    public function __construct()
    {
        $this->table('stock_warecheck_goods');
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

    public function getSum($where='')
    {
        $s = '';
        if(!empty($where)) {
            $s = ' WHERE '.(is_array($where)? implode(' AND ', $where): $where);
        }
        return $this->row("SELECT sum(amount) as amount,sum(total) as total FROM {$this->table} {$s}");
    }

    public function add($data,$shop_id)
    {
        $goods = $this->row("SELECT * FROM {$this->prefix}goods WHERE id='{$data['goods_id']}'");
        if(empty($goods['id'])) {
            return false;
        }
        $stock = $this->one("SELECT stock_num FROM {$this->prefix}stock WHERE shop_id='{$shop_id}' AND  goods_id='{$data['goods_id']}'");
        $stock = is_numeric($stock)? (double)$stock: 0;
        $data['goods_sku'] = $goods['sku'];
        $data['goods_name'] = $goods['name'];
        $data['goods_spec'] = $goods['spec'];
        $data['goods_unit'] = $goods['unit'];
        $data['goods_barcode'] = $goods['barcode'];
        $data['cate_id'] = $goods['cate_id'];
        $data['cate_name'] = $goods['cate_name'];
        $data['pre_amount'] = $stock;
        $data['diff_amount'] = $stock-$data['real_amount'];
        return $this->insert($data);
    }


    public function changeStock($row)
    {        
        if(empty($row['id'])) {
            return false;
        }
        $goods_list = $this->select("SELECT * FROM {$this->table} WHERE warecheck_id={$row['id']}");
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
        foreach($goods_list as $goods) {
            if(isset($stock_list[$goods['goods_id']])) {
                $arr_sql[] = "UPDATE {$table} SET stock_num={$goods['real_amount']},total_cost={$goods['real_amount']}*price_cost WHERE shop_id={$row['shop_id']} AND goods_id={$goods['goods_id']}";
            } else {
                $arr_sql[] = "INSERT INTO {$table}(shop_id,shop_name,goods_id,goods_sku,stock_num,sale_num,price_buy,price_sell,recent_buy,recent_sell,price_cost,total_cost) VALUES( {$row['shop_id']},'{$row['shop_name']}','{$goods['goods_id']}','{$goods['goods_sku']}',{$goods['real_amount']},0,{$goods['price']},0,0,0,{$goods['price']},{$goods['price']}*{$goods['real_amount']})";
            }
        }
        return $this->exec(implode(';',$arr_sql));
    }
}