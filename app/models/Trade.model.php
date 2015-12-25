<?php
class TradeModel extends Model
{
    public function __construct()
    {
        $this->table('order_trade');
    }

    public function getSn($len=5)
    {
        $pre = 'T';
        $date = date('Ymd');
        $max = $this->one("SELECT max(sn) FROM {$this->table}");
        $max = preg_replace("/^{$pre}/i", '', $max);
        $index = '';
        if($date == substr($max, 0, 8)) {
            $max = preg_replace("/^{$date}/i", '', $max);
            $max = (int)$max + 1;
            $index = str_pad((string)$max, $len, '0', STR_PAD_LEFT);
        } else {
            $index = str_pad('1', $len, '0', STR_PAD_LEFT);
        }
        return "{$pre}{$date}{$index}";
    }

    public function getRowBySn($sn)
    {
        return $this->row("SELECT * FROM {$this->table} WHERE sn='{$sn}'");
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
        return $this->row("SELECT sum(ysje) as ysje,sum(ssje) as ssje,sum(yhje) as yhje,sum(qkje) as qkje FROM {$this->table} {$s}");
    }

    public function add($data,$row=array())
    {
        if(isset($row['id'])) {            
            $update = array();
            $is_update = false;
            foreach($data as $k=>$v) {
                if($row[$k] != $v) {
                    $update[$k] = $v;
                    $is_update = true;
                }
            }
            if($is_update) {
                $r = $this->update($update, "id='{$row['id']}'");
                if($this->hasError()) return $r;
            }
            return $row['id'];
        }
        $data['create_time'] = time();
        return $this->insert($data);
    }

}