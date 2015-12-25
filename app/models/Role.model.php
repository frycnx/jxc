<?php
class RoleModel extends Model
{
    public function __construct()
    {
        $this->table('role');
    }

    public function getRowById($id)
    {
        return $this->row("SELECT * FROM {$this->table} where id='{$id}'");
    }

    public function hasUnqiueName($name)
    {
        $all = $this->select("SELECT * FROM {$this->table} where name='{$name}'");
        return !is_array($all)||count($all) < 1;
    }

    public function clearCache()
    {
        $this->cache('role', null);
    }

    public function getCache($id=0)
    {
        $role = $this->cache('role');
        if( $role ) {
            return $id===0? $role: $role[$id];
        }        
        $arr = $this->select("SELECT * FROM {$this->table}");
        $data = array();
        foreach($arr as $val) {
            $data[$val['id']] = $val['name'];
        }
        $this->cache('role', $data);
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