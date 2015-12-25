<?php

/**
 * 数据模型类
 * @author frycn
 */
class Model
{

    /**
     * 数据库对象
     *
     * @var Db
     */
    public $db = null;
    public $table = '';
    public $prefix ='';

    /**
     * 设置表名
     * @param  [type] $table [description]
     * @return [type]        [description]
     */
    public function table($table)
    {
        global $_G;
        $this->prefix = $_G['db_prefix'];
        $this->table = $_G['db_prefix'] . $table;
    }

    public function exec($sql)
    {
        return $this->db->execute($sql);
    }

    /**
     * 获取一个字段
     *
     * @param string $sql            
     * @return mixed
     */
    public function one ($sql)
    {
        $row = $this->row($sql);
        return $row? current($row): $row;
    }

    /**
     * 获取一行数据
     *
     * @param string $sql            
     */
    public function row ($sql)
    {
        return $this->db->fetchArray($this->db->query($sql));
    }

    /**
     * 获取所有数据
     *
     * @param string $sql            
     * @return multitype:unknown
     */
    public function select ($sql,$index='')
    {
        $arr = array();
        $query = $this->db->query($sql);
        if(empty($index)) {
            while ($row = $this->db->fetchArray($query)) {
                $arr[] = $row;
            }
            return $arr;
        } else {
            while ($row = $this->db->fetchArray($query)) {
                $arr[$row[$index]] = $row;
            }
            return $arr;
        }
    }

    /**
     * 插入数据
     *
     * @param string $table            
     * @param string $data            
     * @param string $replace            
     */
    public function insert ($data, $table='', $replace = false)
    {
        $key = array();
        $val = array();
        foreach ($data as $k => $v) {
            if (is_scalar($v)) {
                $key[] = $k;
                $val[] = $this->db->escapeString(trim($v));
            }
        }
        if(empty($table)) {
            $table = $this->table;
        }
        $sql = ($replace ? 'REPLACE' : 'INSERT') . ' INTO ' . $table . ' (`' .
                 implode('`,`', $key) . '`) values (' . implode(',', $val) . ')';
        $r = $this->db->execute($sql);
        return $r? $this->db->insertId(): $r;
    }

    /**
     * 插入所有数据
     *
     * @param string $table            
     * @param string $data            
     * @param string $replace            
     */
    public function insertAll ($data, $table='', $replace = false)
    {
        $key = array();
        $val = array();
        foreach(array_keys(current($data)) as $v){
           $key[] = $v;
        }
        foreach ($data as $one){
            $tmp   =  array();
            foreach ($one as $v){
                $tmp[] = $this->db->escapeString(trim($v));
            }
            $val[]    = '('.implode(',', $tmp).')';
        }
        if(empty($table)) {
            $table = $this->table;
        }
        $sql = ($replace ? 'REPLACE' : 'INSERT') . ' INTO ' . $table . ' (`' .
                 implode('`,`', $key) . '`) VALUES ' . implode(',', $val);
        return $this->db->execute($sql);
    }

    /**
     * 更新数据
     *
     * @param string $table            
     * @param string $data            
     * @param string $where            
     */
    public function update ($data, $where = null, $table='')
    {
        $set = '';
        if (is_array($data)) {
            $val = array();
            foreach ($data as $k => $v) {
                if (is_scalar($v)) {
                    $val[] = "`{$k}`=" . $this->db->escapeString(trim($v));
                }
            }
            $set = implode(',', $val);
        } else {
            $set = $data;
        }
        if(empty($table)) {
            $table = $this->table;
        }
        $sql = 'UPDATE ' . $table . ' SET ' . $set . (is_null($where) ? '' : (' WHERE ' .
                 (is_array($where) ? implode(' AND ', $where) : $where)));
        return $this->db->execute($sql);
    }

    /**
     * 删除数据
     *
     * @param string $table            
     * @param string $where            
     */
    public function delete ($where = null, $table='')
    {
        if(empty($table)) {
            $table = $this->table;
        }
        $sql = 'DELETE FROM ' . $table . (is_null($where) ? '' : (' WHERE ' .
                 (is_array($where) ? implode(' AND ', $where) : $where)));
        return $this->db->execute($sql);
    }

    public function hasError()
    {
        return $this->db->errno()!='00000';
    }

    public function error()
    {
        return $this->db->error();
    }

    public function startTrans ()
    {
        return $this->db->startTrans();
    }

    public function commit ()
    {
        return $this->db->commit();
    }

    public function rollback ()
    {
        return $this->db->rollBack();
    }

    /*
    mysql内存缓存表
    CREATE TABLE IF NOT EXISTS `cache_mysq` (
                `key` varchar(255) NOT NULL,
                `val` varchar(21580) NOT NULL,
                `exp` int(10) NOT NULL,
                PRIMARY KEY (`key`)
    ) ENGINE=MEMORY DEFAULT CHARSET=utf8;
    */
	public function cache($name,$value='',$expire=0)
	{
        global $_G;
		$table = $_G['db_prefix'] . 'cache_mysql';
		if('' === $value) {
			$row = $this->row("SELECT val,exp FROM {$table} WHERE `key`='{$name}'");
            if(!isset($row['val'])) {
                return false;
            }
			if(time() > (int)$row['exp']) {
				$this->exec("DELETE FROM {$table} WHERE `key`='{$name}'");
				return false;
			}
			return unserialize($row['val']);
		} else {
			if(is_null($value)) {
				return $this->exec("DELETE FROM {$table} WHERE `key`='{$name}'");
			} else {
				$val = serialize($value);
				$time = $expire>0? time()+$expire: time()*2;
				return $this->exec("REPLACE INTO {$table}(`key`,`val`,`exp`) VALUES('{$name}','{$val}',{$time})");
			}
		}		
	}
}