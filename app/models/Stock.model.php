<?php
class StockModel extends Model
{
    public function __construct()
    {
        $this->table('stock');
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
        return $this->select("SELECT * FROM {$this->table} s LEFT JOIN {$this->prefix}goods g ON s.goods_id=g.id {$s}");
    }

    public function getCount($where='')
    {
        $s = '';
        if(!empty($where)) {
            $s = ' WHERE '.(is_array($where)? implode(' AND ', $where): $where);
        }
        return $this->one("SELECT count(*) as count FROM {$this->table} s LEFT JOIN {$this->prefix}goods g ON s.goods_id=g.id {$s}");
    }

    public function getSum($where='')
    {
        $s = '';
        if(!empty($where)) {
            $s = ' WHERE '.(is_array($where)? implode(' AND ', $where): $where);
        }
        return $this->row("SELECT sum(stock_num) as stock_num,sum(sale_num) as sale_num,sum(price_buy) as price_buy,sum(price_sell) as price_sell,sum(price_cost) as price_cost,sum(total_cost) as total_cost,sum(total_sell) as total_sell FROM {$this->table} s LEFT JOIN {$this->prefix}goods g ON s.goods_id=g.id {$s}");
    }

    public function getRowById($shop_id,$id)
    {
        return $this->row("SELECT * FROM {$this->table} WHERE shop_id='{$shop_id}' AND goods_id='{$id}'");
    }

    public function editGoodsStock($data)
    {
        $shop_ids = array();
        $goods_ids = array();
        foreach($data as $val) {
            $shop_ids[] = $val['shop_id'];
            $goods_ids[] = $val['goods_id'];
        }
        $stock_list = $this->select("SELECT concat(shop_id,goods_id) as shop_goods FROM {$this->table} WHERE shop_id in(".implode(',',$shop_ids).') AND goods_id in('.implode(',',$goods_ids).')','shop_goods');
        $arr_sql = array();
        foreach($data as $tmp) {
            if(isset($stock_list[$tmp['shop_id'].$tmp['goods_id']])) {
                $arr_sql[] = "UPDATE {$this->table} SET shop_name='{$tmp['shop_name']}',goods_sku='{$tmp['goods_sku']}',price_sell='{$tmp['price_sell']}' WHERE shop_id={$tmp['shop_id']} AND goods_id={$tmp['goods_id']}";
            } else {
                $arr_sql[] = "INSERT INTO {$this->table}(shop_id,shop_name,goods_id,goods_sku,price_sell) VALUES( '{$tmp['shop_id']}','{$tmp['shop_name']}','{$tmp['goods_id']}','{$tmp['goods_sku']}','{$tmp['price_sell']}')";
            }
        }
        return $this->exec(implode(';',$arr_sql));
    }

    public function getGoodsStock($goods_ids,$shop_ids='')
    {
        $s = '';
        if($shop_ids) {
            if(is_array($shop_ids)) {
                $s = 'shop_id in('.implode(',',$shop_ids).')';
            } else {
                $s = 'shop_id='.$shop_ids;
            }
        }
        if(is_array($goods_ids)) {
            $s = 'goods_id in('.implode(',',$goods_ids).')';
        } else {
            $s = 'goods_id='.$goods_ids;
        }
        return $this->select("SELECT * FROM {$this->table} WHERE {$s}",'shop_id');
    }

    public function getStockList($where='', $order='', $limit='')
    {
        $s = '';
        if(!empty($where)) {
            $s .= ' AND ' . is_array($where) ? implode(' AND ', $where) : $where;
        }
		if(!empty($order)) {
            $s .= ' ORDER BY ' . $order;
		}
        if(!empty($limit)) {
            $s .= ' LIMIT ' . $limit;
        }
        return $this->select("SELECT g.id as goods_id,g.sku as goods_sku,g.name as goods_name,g.spec as goods_spec,g.origin as goods_origin,g.unit as goods_unit,g.pinyin as goods_pinyin,g.barcode as goods_barcode,g.cate_id,g.cate_name,g.is_stock,s.id as stock_id,s.shop_id,s.shop_name,s.stock_num,s.sale_num,s.price_buy,s.price_sell,s.recent_buy,s.recent_sell,s.price_cost,s.total_cost FROM jxc_goods g LEFT JOIN jxc_stock s ON g.id=s.goods_id {$s}");
    }
}