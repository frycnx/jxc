<?php
class SaleGoodsModel extends Model
{
    public function __construct()
    {
        $this->table('order_sale_goods');
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
        return $this->row("SELECT sum(stock) as stock,sum(amount) as amount,sum(total) as total FROM {$this->table} {$s}");
    }

    public function add($data,$shop_id=0)
    {
        if(empty($data['goods_id'])) {
            return false;
        }
        $goods = $this->row("SELECT * FROM {$this->prefix}goods WHERE id='{$data['goods_id']}'");
        if(empty($goods['id'])) {
            return false;
        }
        $stock = $this->one("SELECT stock_num FROM {$this->prefix}stock WHERE shop_id='{$shop_id}' AND  goods_id='{$data['goods_id']}'");
        $data['goods_sku'] = $goods['sku'];
        $data['goods_name'] = $goods['name'];
        $data['goods_spec'] = $goods['spec'];
        $data['goods_unit'] = $goods['unit'];
        $data['goods_barcode'] = $goods['barcode'];
        $data['cate_id'] = $goods['cate_id'];
        $data['cate_name'] = $goods['cate_name'];
        $data['stock'] = is_numeric($stock)? (double)$stock: 0;
        $data['total'] = (float)$data['discount']*(float)$data['amount']*(float)$data['price'];
        return $this->insert($data);
    }

    public function memberGoods($row, $member) {
        if(empty($row['id'])) {
            return false;
        }
        if(empty($member['id'])) {
            return false;
        }
        $goods_list = $this->select("SELECT sg.*,gs.price_sale,gs.price_member,gs.sale_time_type,gs.sale_time,gs.status FROM {$this->table} sg LEFT JOIN {$this->prefix}goods_sale gs ON sg.goods_id=gs.goods_id WHERE sg.sale_id={$row['id']}");
        $arr_sql = array();
        foreach($goods_list as $goods) {
            if(!$goods['status']) {
                continue;
            }
            $price = $goods['price'];
            $discount = $goods['discount'];            
            if($goods['sale_time_type']=='a') {
                if(is_numeric($goods['price_member'])&&isset($member['id'])) {
                    $price = $goods['price_member'];
                } else if(is_numeric($goods['price_sale'])) {
                    $price = $goods['price_sale'];
                }
            }elseif($goods['sale_time_type']=='w') {
                if(in_array(date('w'),explode(',',$goods['sale_time']))) {
                    if(is_numeric($goods['price_member'])&&isset($member['id'])) {
                        $price = $goods['price_member'];
                    } else if(is_numeric($goods['price_sale'])) {
                        $price = $goods['price_sale'];
                    }
                }
            }elseif($goods['sale_time_type']=='t') {
                $time = time();
                $arr = explode(',',$goods['sale_time']);
                $check = is_numeric($arr[0]) && $time>$arr[0];
                $check = is_numeric($arr[1])?($check&&$time<$arr[1]):$check;
                if( $check ) {
                    if(is_numeric($goods['price_member'])&&isset($member['id'])) {
                        $price = $goods['price_member'];
                    } else if(is_numeric($goods['price_sale'])) {
                        $price = $goods['price_sale'];
                    }
                }
            }elseif(isset($member['id'])) {
                $discount = $member['level_discount'];
            }
            $arr_sql[] = "UPDATE {$this->table} SET discount={$discount},price={$price},total={$discount}*{$price}*amount WHERE id={$goods['id']}";
        }
        echo implode(';',$arr_sql);
        return $this->exec(implode(';',$arr_sql));
    }

    public function changeStock($row, $goods_list)
    {        
        $goods_ids = array();
        foreach($goods_list as $goods) {
            $goods_ids[] = $goods['goods_id'];
        }
        $stock_list = $this->select("SELECT goods_id FROM {$this->prefix}stock WHERE shop_id={$row['shop_id']} AND goods_id in(".implode(',',$goods_ids).')','goods_id');
        $arr_sql = array();
        foreach($goods_list as $goods) {
            if(isset($stock_list[$goods['goods_id']])) {
                $arr_sql[] = "UPDATE {$this->prefix}stock SET stock_num=stock_num-{$goods['amount']},sale_num=sale_num+{$goods['amount']},recent_sell={$goods['price']},total_cost=(stock_num-{$goods['amount']})*price_cost WHERE shop_id={$row['shop_id']} AND goods_id={$goods['goods_id']}";
            } else {
                $arr_sql[] = "INSERT INTO {$this->prefix}stock (shop_id,shop_name,goods_id,goods_sku,stock_num,sale_num,price_buy,price_sell,recent_buy,recent_sell,price_cost,total_cost) VALUES( {$row['shop_id']},'{$row['shop_name']}','{$goods['goods_id']}','{$goods['goods_sku']}',-{$goods['amount']},{$goods['amount']},0,{$goods['price']},0,{$goods['price']},0,0)";
            }
        }
        return $this->exec(implode(';',$arr_sql));
    }
}
