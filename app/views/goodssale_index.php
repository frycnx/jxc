<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>商品特价</title>
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
                <li>商品管理</li>
                <li class="active">商品特价</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>特价列表</h4>
                            <div class="options">
                                <div class="btn-toolbar">
                                    <a href="<?php echo url('GoodsSale','goods')?>" class="btn btn-default goodsGoodsSale"><i class="fa fa-plus"></i><span class="hidden-sm"> 新增特价  </span></a>
                                    <a href='<?php echo url('GoodsSale','import')?>' class="btn btn-default"><i class="fa fa-cloud-download importGoodsSale"></i><span class="hidden-sm"> 导出  </span></a>
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
                            <select size="1" class="form-control" name="shop_id">
                            <option value="">---</option>
                            <?php foreach($my_shop as $key=>$val):?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
                            <select size="1" class="form-control" name="cate_id">
                            <option value="">---</option>
                            <?php foreach($category as $key=>$val):?>
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
                                  <th>店铺</th>
                                  <th>SKU</th>
                                  <th>名称</th>
                                  <th>规格</th>
                                  <th>单位</th>
                                  <th>原价</th>
                                  <th>特价</th>
                                  <th>会员价</th>
                                  <th>期限</th>
                                  <th>状态</th>
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
                            <div class="col-xs-8 text-right" id="table_page"></div>
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
<link href="static/js/jqueryui.css" rel="stylesheet" media="all">
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type="text/javascript" src="static/js/jquery.form.js"></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<?php include 'ajax_load.php';?>
<script type="text/javascript">
$("#_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('GoodsSale')?>',
	"columns": [
            {"name":"shop_name", "data": "shop_name" },
			{"name":"goods_sku", "data": "goods_sku"},
			{"name":"name", "data": "name"},
      {"name":"spec", "data": "spec" },
      {"name":"unit", "data": "unit" },
      {"name":"price_sell", "data": "price_sell" },
      {"name":"price_sale", "data": "price_sale" },
      {"name":"price_member", "data": "price_member" },
      {"name":"sale_time", "data": function(d){
        if(d['sale_time_type']=='a'){
          return '无限期'
        }else if(d['sale_time_type']=='t'){
          var ar = d['sale_time'].split(',');
          return date('Y-m-d',ar[0]) + '至' + date('Y-m-d',ar[1]);
        }else if(d['sale_time_type']=='w'){
          var ar = d['sale_time'].split(',');
          var st = '';
          if($.inArray('1',ar) > -1) {
            st += ',周一';
          }
          if($.inArray('2',ar) > -1) {
            st += ',周二';
          }
          if($.inArray('3',ar) > -1) {
            st += ',周三';
          }
          if($.inArray('4',ar) > -1) {
            st += ',周四';
          }
          if($.inArray('5',ar) > -1) {
            st += ',周五';
          }
          if($.inArray('6',ar) > -1) {
            st += ',周六';
          }
          if($.inArray('0',ar) > -1) {
            st += ',周日';
          }
          return st.substr(1);
        }} },
			{"name":"status", "data": function(d){return '<i class="fa '+(d["status"]=='1'?'fa-check-circle':'fa-times-circle')+'"></i>';} },
			{ "data": function(d){return '<div class="btn-group"><a class="editGoodsSale" href="<?php echo url('GoodsSale','edit')?>&id='+d["id"]+'" title="编辑"><i class="fa fa-edit"></i><span class="hidden-sm">编辑</span></a></div>&nbsp;<div class="btn-group"><a class="delGoodsSale" href="<?php echo url('GoodsSale','del')?>&id='+d["id"]+'" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div>';}, "sortable": false}
		],
    "complete": function(){
        $(".editGoodsSale").click(function(){
            ajaxLoad(this.href);
            return false;
        });
        $(".delGoodsSale").click(function(){
            $.ajax({
              type: "GET",
              url: this.href,
              dataType: "json",
              beforeSend: function (){
                  showMsg('正在删除...');
              },
              error: function (){
                  showMsg('删除失败,请联系管理员');
              },
              success : function (d){
                if(d.state) {
                    showSuccess(d.info,function(){$("#_table").trigger('ajaxLoad');});
                } else {
                    showError(d.info,function(){$("#_table").trigger('ajaxLoad');});
                }
              }
            });
            return false;
        });
        $("#_table tbody tr").dblclick(function(){
			$(this).find(".editGoodsSale").click();
        });
    }
});
$(".goodsGoodsSale").click(function(){
    ajaxLoad(this.href);
    return false;
});
$(".importGoodsSale").click(function(){
    var url = this.href;
    $("#_table").trigger('getParams',function(d){
		window.open(url + (url.indexOf('?')>=0?'&':'?') + d);
    });
    return false;
});
function oneGoodsModalFinish(d){
    ajaxLoad('<?php echo url('GoodsSale','add')?>&id='+d["id"]+'&shop_id='+d["shop_id"]);
}
</script>
</body>
</html>