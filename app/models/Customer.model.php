<?php
class CustomerModel extends Model
{
    public function __construct()
    {
        $this->table('customer');
    }

	public function getNewSn($len=6)
	{
        $pre = 'C';
        $max = $this->one("SELECT max(sn) FROM {$this->table}");
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

    public function updateMoney($where='', $arr=array())
    {
		$p = array('money','overdraft','offer','consume');
		$set = array();
		foreach($arr as $k=>$v) {
			if(in_array($k,$p)) {
				$set[] = "{$k}={$k}+{$v}";
			}
		}
		if(count($set)<1) {
			return false;
		}
        return $this->exec("UPDATE {$this->table} SET " . implode(',', $set) . ' WHERE '.(is_array($where) ? implode(' AND ', $where) : $where));
    }
}