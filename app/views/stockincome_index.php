<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>直接入库</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="static/css/style.css" rel="stylesheet" media="all">
	<link href="static/css/font-awesome.css" rel="stylesheet" media="all">
</head>

<body>
    <?php include 'header.php';?>

    <div id="page-container">

        <?php include 'nav.php';?>

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ol class="breadcrumb">
                <li>库存管理</li>
                <li class="active">直接入库</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>直接入库</h4>
                            <div class="options">
                                <div class="btn-toolbar">
                                    <a href='<?php echo url('StockIncome','add')?>' class="btn btn-default"><i class="fa fa-plus"></i><span class="hidden-sm"> 新增入库  </span></a>
                                    <a href='<?php echo url('StockIncome','export')?>' class="btn btn-default"><i class="fa fa-cloud-download"></i><span class="hidden-sm"> 导出  </span></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-xs-3 text-left">
							<div class="form-inline form-group">
							<select size="1" class="form-control" id="_table_num"><option value="25">25</option><option value="50">50</option><option value="100">100</option></select><label class="control-label">条/页</label>
							</div>
							</div>
                            <div class="col-xs-9 text-right">
							<form class="form-inline" id="_table_search">
							<div class="form-group">
                            <select size="1" class="form-control" name="shop_id" id="shop_id" required="required">
                            <option value="">---</option>
                            <?php foreach($my_shop as $key=>$val):?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
							<input type="text" name="kw" class="form-control" placeholder="关键词...">
							<input type="submit" class="btn" value="搜索"/>
                            </div>
                            </form>
							</div>							
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="_table">
                                <thead>
                                    <tr>
                                    <th>时间</th>
                                    <th>单号</th>
                                    <th>类型</th>
                                    <th>店铺</th>
                                    <th>用户</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-4 text-left"><label class="control-label" id="_table_info"></label></div>
                            <div class="col-xs-8 text-right" id="_table_page"></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container -->
    </div> <!--wrap -->
</div> <!-- page-content -->

<?php include 'footer.php';?>

</div> <!-- page-container -->

<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<script type="text/javascript">
$("#_table").ajaxTable({
    "loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "_table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('StockIncome')?>',
	"columns": [
            {"name":"create_time", "data": function(d){return date('Y-m-d',d['create_time']);} },
			{"name":"sn", "data": "sn"},
            {"name":"type", "data": function(d){if(d['type']=='1'){return '采购进货';}else if(d['type']=='2'){return '商品报溢';}else if(d['type']=='3'){return '商品还货';}else if(d['type']=='4'){return '其他入库';}} },
            {"name":"shop_name", "data": "shop_name"},
            {"name":"user_name", "data": "user_name"},            
            {"name":"status", "data": function(d){return '<i class="fa '+(d["status"]=='1'?'fa-check-circle':'fa-times-circle')+'"></i>';} },
            {"name":"memo", "data": "memo"},
			{ "data": function(d){return d["status"]=='1'?'<div class="btn-group"><a class="addStockIncome" href="<?php echo url('StockIncome','add')?>&sn='+d["sn"]+'" title="查看"><i class="fa fa-edit"></i><span class="hidden-sm">查看</span></a></div>':('<div class="btn-group"><a class="addStockIncome" href="<?php echo url('StockIncome','add')?>&sn='+d["sn"]+'" title="编辑"><i class="fa fa-edit"></i><span class="hidden-sm">编辑</span></a></div>&nbsp;<div class="btn-group"><a class="delStockIncome" href="<?php echo url('StockIncome','del')?>&id='+d["id"]+'" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div>');}, "sortable": false}
		],
    "complete": function(cb){
        $('.delStockIncome').click(function(){
        $.ajax({
          type: "GET",
          url: $(this).attr('href'),
          dataType: "json",
          beforeSend: function (){
              showError('正在删除...');
          },
          error: function (){
              showError('删除失败,请联系管理员');
          },
          success : function (d){
                if(d.state) {
                    showSuccess(d.info,function(){cb('reload')});
                } else {
                    showError(d.info,function(){cb('reload')});
                }
          }
        });
        return false;
       });
        $("#_table tbody tr").dblclick(function(){
            window.location.href=$(this).find(".addStockIncome").attr("href");
        });
    }
});
</script>
</body>
</html>