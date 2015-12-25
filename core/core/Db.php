<?php
/**
 * 连接数据库
 * @author frycn
 *
 */
class Db
{

    private $type = null;

    private $link = null;

    public function __construct ($config)
    {
        $dsn = $this->_pdoDsn($config);
        if(empty($dsn)) {
            return;
        }   
        $this->connect($dsn, $config['db_user'], $config['db_pass']);
        if(!empty($config['db_charset'])) {
            $this->setCharset($config['db_charset']);
        }    
    }
    
    public function connect($dsn, $dbuser = '', $dbpw = '', $pconnect = false){
        try {
            $this->link = new PDO($dsn, $dbuser, $dbpw,
                    ($pconnect ? array(
                            PDO::ATTR_PERSISTENT => true
                    ) : array()));
            $this->type = strtoupper(
                    $this->link->getAttribute(PDO::ATTR_DRIVER_NAME));
        } catch (PDOException $e) {
            $this->halt($e->getMessage());
        }
    }
    
    
    /**
     * 改变当前数据库
     * @param string $dbname
     * @return boolean
     */
    public function selectDb ($dbname)
    {
        return $this->link->exec("USE {$dbname}") === false ? false : true;
    }
    

    /**
     * 设置连接编码
     * @param string $dbcharset
     */
    public function setCharset ($dbcharset)
    {
        switch ($this->type) {
            case 'ORACLE':
            case 'OCI':
                $this->link->exec("SET NLS_LANG={$dbcharset}");
                break;
            case 'MSSQL':
                $this->link->exec("SET LANGUAGE {$dbcharset}");
                break;
            case 'PGSQL':
            case 'IBASE':
            case 'SQLITE':
                break;
            case 'MYSQL':
            default:
                if (strtoupper($dbcharset) == 'UTF-8') {
                    $dbcharset = 'UTF8';
                }
                $this->link->exec("SET NAMES {$dbcharset}");
        }
    }
    
    
    /**
     * 设置链接属性
     * @param string $key
     * @param string $val
     */
    public function setAttr ($key, $val)
    {
        $this->link->setAttribute($key, $val);
    }

    /**
     * 执行查询
     * @param string $sql
     * @return unknown
     */
    public function query ($sql)
    {
        // $this->link->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,$b);
        $query = $this->link->query($sql);
        if (! $query) {
            $this->halt('Query Error', $sql);
        }
        return $query;
    }
    
    /**
     * 执行查询
     * @param string $sql
     */
    public function execute ($sql)
    {
        return $this->link->exec($sql);
    }

    public function fetchArray ($query, $result_type = PDO::FETCH_ASSOC)
    {
        return $query->fetch($result_type);
    }

    public function escapeString ($str)
    {
        return $this->link->quote($str);
    }

    public function insertId ()
    {
        return $this->link->lastInsertId();
    }

    public function startTrans ()
    {
        return $this->link->beginTransaction();
    }

    public function commit ()
    {
        return $this->link->commit();
    }

    public function rollback ()
    {
        return $this->link->rollBack();
    }

    public function error ()
    {
        return $this->link->errorInfo();
    }

    public function errno ()
    {
        return $this->link->errorCode();
    }

    /**
     * 获取数据库表
     * @param string $dbName
     * @return multitype:mixed
     */
    public function getTables ($dbName = '')
    {
        switch ($this->type) {
            case 'ORACLE':
            case 'OCI':
                $sql = 'SELECT table_name FROM user_tables';
                break;
            case 'MSSQL':
                $sql = "SELECT TABLE_NAME	FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'";
                break;
            case 'PGSQL':
                $sql = "select tablename as Tables_in_test from pg_tables where  schemaname ='public'";
                break;
            case 'IBASE':
                
                // 暂时不支持
                $this->halt('NOT SUPPORT IBASE');
                break;
            case 'SQLITE':
                $sql = "SELECT name FROM sqlite_master WHERE type='table' " .
                         "UNION ALL SELECT name FROM sqlite_temp_master " .
                         "WHERE type='table' ORDER BY name";
                break;
            case 'MYSQL':
            default:
                $sql = 'SHOW TABLES ' . (empty($dbName) ? '' : " FROM {$dbName}");
        }
        $result = $this->fetch_all($sql);
        $info = array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
    
    /**
     * 获取表字段
     * @param string $table
     * @return multitype:multitype:boolean string Ambigous <unknown, string> Ambigous <boolean, unknown> unknown
     */
    public function getFields ($table)
    {
        switch ($this->type) {
            case 'MSSQL':
                $sql = "SELECT   column_name as 'Name',   data_type as 'Type',   column_default as 'Default',   is_nullable as 'Null'
				FROM    information_schema.tables AS t
				JOIN    information_schema.columns AS c
				ON  t.table_catalog = c.table_catalog
				AND t.table_schema  = c.table_schema
				AND t.table_name    = c.table_name
				WHERE   t.table_name = '{$table}'";
                break;
            case 'SQLITE':
                $sql = "PRAGMA table_info ({$table}) ";
                break;
            case 'ORACLE':
            case 'OCI':
                $sql = "SELECT a.column_name \"Name\",data_type \"Type\",decode(nullable,'Y',0,1) notnull,data_default \"Default\",decode(a.column_name,b.column_name,1,0) \"pk\" " .
                         "FROM user_tab_columns a,(SELECT column_name FROM user_constraints c,user_cons_columns col " .
                         "WHERE c.constraint_name=col.constraint_name AND c.constraint_type='P' and c.table_name='" .
                         strtoupper($table) . "') b where table_name='" .
                         strtoupper($table) .
                         "' and a.column_name=b.column_name(+)";
                break;
            case 'PGSQL':
                $sql = 'select fields_name as "Name",fields_type as "Type",fields_not_null as "Null",fields_key_name as "Key",fields_default as "Default",fields_default as "Extra" from table_msg(' .
                         $table . ');';
                break;
                $this->halt('NOT SUPPORT IBASE');
            case 'IBASE':
                break;
            case 'MYSQL':
            default:
                $sql = 'DESCRIBE ' . $table; // 备注: 驱动类不只针对mysql，不能加``
        }
        $result = $this->fetch_all($sql);
        $info = array();
        if ($result) {
            foreach ($result as $key => $val) {
                $val['Name'] = isset($val['name']) ? $val['name'] : $val['Name'];
                $name = strtolower(
                        isset($val['Field']) ? $val['Field'] : $val['Name']);
                $info[$name] = array(
                        'name' => $name,
                        'type' => isset($val['Type']) ? $val['Type'] : $val['type'],
                        'notnull' => (bool) (((isset($val['Null'])) &&
                                 ($val['Null'] === '')) ||
                                 ((isset($val['notnull'])) &&
                                 ($val['notnull'] === ''))), // not
                                                                                                                                                                 // null
                                                                                                                                                                 // is
                                                                                                                                                                 // empty,
                                                                                                                                                                 // null
                                                                                                                                                                 // is
                                                                                                                                                                 // yes
                                'default' => isset($val['Default']) ? $val['Default'] : (isset(
                                        $val['dflt_value']) ? $val['dflt_value'] : ""),
                                'primary' => isset($val['Key']) ? strtolower(
                                        $val['Key']) == 'pri' : (isset(
                                        $val['pk']) ? $val['pk'] : false),
                                'autoinc' => isset($val['Extra']) ? strtolower(
                                        $val['Extra']) == 'auto_increment' : (isset(
                                        $val['Key']) ? $val['Key'] : false)
                );
            }
        }
        return $info;
    }
    
    /**
     * 数据错误
     * @param string $message
     * @param string $sql
     */
    public function halt ($message = '', $sql = '')
    {
        echo $message;
        echo '<br /><br />' . $sql . '<br /> ';
        $err = $this->error();
        if($err) {
            if(is_array($err)) {
                echo implode('<br />', $err);
            } else {
                echo $err;
            }
        }
        exit;
    }
    
    /**
     * 生成dsn串
     * @param array $c
     * @return string
     */
    private function _pdoDsn ($c)
    {
        $dsn = '';
        switch (strtoupper($c['db_type'])) {
            case 'ORACLE':
            case 'OCI':
                $dsn .= 'oci:dbname=//' . $c['db_host'];
                $dsn .= ':' . (is_numeric($c['db_port']) ? $c['db_port'] : '1521');
                $dsn .= '/' . $c['db_name'];
            case 'MSSQL':
                $dsn .= 'mssql:host=' . $c['db_host'];
                $dsn .= ',' . (is_numeric($c['db_port']) ? $c['db_port'] : '1433');
                $dsn .= ';dbname=' . $c['db_name'];
            case 'PGSQL':
                $dsn .= 'pgsql:host=' . $c['db_host'];
                $dsn .= ' port=' .
                         (is_numeric($c['db_port']) ? $c['db_port'] : '5432');
                $dsn .= ' dbname=' . $c['db_name'];
            case 'IBASE':
                $dsn .= 'ibm:DRIVER={IBM DB2 ODBC DRIVER}';
                $dsn .= ';DATABASE=' . $c['db_name'];
                $dsn .= ';HOSTNAME=' . $c['db_host'];
                $dsn .= ';PORT=' .
                         (is_numeric($c['db_port']) ? $c['db_port'] : '56789');
                $dsn .= ';PROTOCOL=TCPIP';
            case 'SQLITE':
                $dsn .= 'sqlite:' . $c['db_name'];
            case 'MYSQL':
            default:
                $dsn .= 'mysql:host=' . $c['db_host'];
                $dsn .= ';port=' .
                         (is_numeric($c['db_port']) ? $c['db_port'] : '3306');
                $dsn .= ';dbname=' . $c['db_name'];
        }
        return $dsn;
    }
}
