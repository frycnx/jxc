<?php
class GoodsModel extends Model
{
    public function __construct()
    {
        $this->table('goods');
    }

    public function getNewSku($len=6)
    {
        $pre = 'G';
        $max = $this->one("SELECT max(sku) FROM {$this->table}");
        if($max) {
            $max = ltrim($max, $pre);
            $index = str_pad((string)((int)$max+1), $len, '0', STR_PAD_LEFT);
        } else {
            $index = str_pad('1', $len, '0', STR_PAD_LEFT);
        }
        return "{$pre}{$index}";
    }

    public function getRowById($id)
    {
        return $this->row("SELECT * FROM {$this->table} WHERE id='{$id}'");
    }

    public function getRowBySku($sku)
    {
        return $this->row("SELECT * FROM {$this->table} WHERE sku='{$sku}'");
    }

    public function getRowByName($name)
    {
        return $this->row("SELECT * FROM {$this->table} WHERE name='{$name}'");
    }

    public function hasUnqiueName($name)
    {
        $all = $this->select("SELECT * FROM {$this->table} WHERE name='{$name}'");
        return !is_array($all)||count($all) < 1;
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
}