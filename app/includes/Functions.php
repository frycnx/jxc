<?php
function getHash()
{
    return $_SESSION['hash_code'] = randStr();
}

function inputHash()
{
    return '<input type="hidden" name="hash" value="' . getHash() . '">';
}

function isAjaxTable()
{
    if(isset($_SERVER['HTTP_ACCESS_WITH'])) {
        return $_SERVER['HTTP_ACCESS_WITH'] == 'Ajax-Table';
    }
    return FALSE;
}

function verifyHash($key)
{
    if(isset($_SESSION['hash_code']) && $_SESSION['hash_code']==$key) {
        return TRUE;
    }
    return FALSE;
}

function limit ($row=0, $offset=0)
{
    $limit = '';
    if($offset > 0) {
        $limit = $offset.',';
    }
    return $limit . $row;
}

function page ($perpage=30, $page=1, $per_name='perpage',$p_name='page')
{
    $per = (int)request($per_name, $perpage);
    return (((int)request($p_name, $page)-1) * $per) . ',' . $per;
}

function option($id=0)
{
    static $cache = array();
    if( !isset($cache[$id]) ) {
        $cache[$id] = m('Option')->getCache($id);
    }
    return $cache[$id];
}

function getMemberLevel($id=0)
{
    static $cache = array();
    if( !isset($cache[$id]) ) {
        $cache[$id] = m('MemberLevel')->getCache($id);
    }
    return $cache[$id];
}

function getShop($id=0)
{
    static $cache = array();
    if( !isset($cache[$id]) ) {
        $cache[$id] = m('Shop')->getCache($id);
    }
    return $cache[$id];
}

function getCategory($id=0)
{
    static $cache = array();
    if( !isset($cache[$id]) ) {
        $cache[$id] = m('Category')->getCache($id);
    }
    return $cache[$id];
}

function getRole($id=0)
{
    static $cache = array();
    if( !isset($cache[$id]) ) {
        $cache[$id] = m('Role')->getCache($id);
    }
    return $cache[$id];
}

function getMyRight()
{
    static $cache = null;
    if( $cache ) {
        return $cache;
    }
    $row = m('Role')->getRowById($_SESSION['role_id']);
    if($row['rights']) {
        $rights = unserialize($row['rights']);
        if(isset($rights['rights'])) {
            $cache = $rights['rights'];
            return $rights['rights'];
        }
    }
    return array();
}

function getMyShopId()
{
    static $cache = null;
    if( $cache ) {
        return $cache;
    }
    $row = m('Role')->getRowById($_SESSION['role_id']);
    if($row['rights']) {
        $rights = unserialize($row['rights']);
        if(isset($rights['shops'])) {
            $cache = $rights['shops'];
            return $rights['shops'];
        }
    }
    return array();
}

function getMyShop()
{
    static $cache = null;
    if( $cache ) {
        return $cache;
    }
    $shop_id = getMyShopId();
    $shops = getShop();
    $shop = array();
    foreach($shops as $k=>$v) {
        if(in_array($k,$shop_id)) {
            $shop[$k] = $v;
        }
    }
    return $cache = $shop;
}

function getPinYin($str)
{
    global $_G;
	$pinyin='';
    $len = mb_strlen($str,'utf-8');
    if(!$len) {
        return $pinyin;
    }
    $db = db();
    for($i=0; $i<$len; $i++) { 
        $s = mb_substr($str, $i, 1,'utf-8');
        $py = $db->fetchArray($db->query("select zjm from {$_G['db_prefix']}pinyin where hanzi='{$s}'"));
        if(isset($py['zjm'])) {
            $pinyin .= trim($py['zjm']);
        } else {
            $pinyin .= $s;
        }
     }
     return $pinyin; 
}

function outXls($data, $name)
{
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename='{$name}.xls'");
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    //header('Cache-Control: max-age=1');
    echo "\xEF\xBB\xBF";
    echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    echo '<head>';
    echo '<!--[if gte mso 9]>';
    echo '<xml>';
    echo '<x:ExcelWorkbook>';
    echo '<x:ExcelWorksheets>';
    echo '<x:ExcelWorksheet>';
    echo "<x:Name>{$name}</x:Name>";
    echo '<x:WorksheetOptions><x:print><x:ValidPrinterInfo /></x:print></x:WorksheetOptions>';
    echo '</x:ExcelWorksheet>';
    echo '</x:ExcelWorksheets>';
    echo '</x:ExcelWorkbook>';
    echo '</xml>';
    echo '<![endif]-->';
    echo '<style>td{vnd.ms-excel.numberformat:@;mso-number-format:"\@"}</style>';
    echo '</head>';
    echo '<body>';
    echo $data;
    echo '</body>';
    echo '</html>';
}