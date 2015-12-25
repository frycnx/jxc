<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>库存查询</title>
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
                <li>库存查询</li>
                <li class="active">库存查询</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>库存查询</h4>
                            <div class="options">
                                <div class="btn-toolbar">
                                    <a href='<?php echo url('Stock','export')?>' class="btn btn-default exportStock"><i class="fa fa-cloud-download"></i><span class="hidden-sm"> 导出  </span></a>
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
                            <select size="1" class="form-control" name="cate_id" id="cate_id">
                            <option value="">---</option>
                            <?php foreach($category as $key=>$val):?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
                            <select size="1" class="form-control" name="shop_id" id="shop_id">
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
                                    <th>SKU</th>
                                    <th>商品</th>
                                    <th>规格</th>
                                    <th>单位</th>
                                    <th>分类</th>
                                    <th>店铺</th>
                                    <th>库存</th>
                                    <th>成本价</th>
                                    <th>成本总额</th>
                                    <th>销量</th>
                                    <th>售价</th>
                                    <th>销售总额</th>
                                    <th style="display:none">操作</th>
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
<script type='text/javascript' src='static/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/jquery.cookie.js'></script>
<script type='text/javascript' src='static/js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<?php include 'ajax_load.php';?>
<script type="text/javascript">
$("#_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "_table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('Stock')?>',
	"columns": [
			{"name":"sku", "data": "sku"},
			{"name":"name", "data": "name"},
            {"name":"spec", "data": "spec"},
            {"name":"unit", "data": "unit"},
            {"name":"cate_name", "data": "cate_name"},
            {"name":"shop_name", "data": "shop_name"},
            {"name":"stock_num", "data": "stock_num", "sum": "stock_num"},
            {"name":"price_cost", "data": "price_cost", "sum": "price_cost"},
            {"name":"total_cost", "data": "total_cost", "sum": "total_cost"},
            {"name":"sale_num", "data": "sale_num", "sum": "sale_num"},
            {"name":"price_sell", "data": "price_sell", "sum": "price_sell"},
            {"name":"total_sell", "data": "total_sell", "sum": "total_sell"},
            {"data": function(d){return '<a class="showFlow" href="<?php echo url('Stock','Detail')?>&goods_id='+d["goods_id"]+'&shop_id='+d["shop_id"]+'"></a>';}, "attr": "style='display:none'"}
            ],
    "complete": function(d){
        $("#_table tbody tr").dblclick(function(){
            ajaxLoad($(this).find(".showFlow").attr("href"));
        });
    }
});
$(".exportStock").click(function(){
    var url = this.href;
    $("#_table").trigger('getParams',function(d){
        window.open(url + (url.indexOf('?')>=0?'&':'?') + d);
    });
    return false;
});
</script>
</body>
</html>