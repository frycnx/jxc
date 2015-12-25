<?php
class OptionModel extends Model
{
    public function __construct()
    {
        $this->table('option');
    }

    public function clearCache()
    {
        $this->cache('option', null);
    }

    public function getCache($id=0)
    {
        $opt = $this->cache('option');
        if( $opt ) {
            return $id===0? $opt: $opt[$id];
        }
        $arr = $this->select("SELECT * FROM {$this->table}");
        $data = array();
        foreach($arr as $val) {
            $data[$val['key']] = $val['val'];
        }
        $this->cache('option', $data);
        return $id===0? $data: $data[$id];
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