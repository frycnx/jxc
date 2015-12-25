<?php
class UserModel extends Model
{
    public function __construct()
    {
        $this->table('user');
    }

    public function getRowById($id){
        return $this->row("SELECT * FROM {$this->table} where id='{$id}'");
    }
    
	public function getRowByName($username){
		return $this->row("SELECT * FROM {$this->table} where username='{$username}'");
	}

    public function hasUnqiueName($username)
    {
        $all = $this->select("SELECT * FROM {$this->table} where username='{$username}'");
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