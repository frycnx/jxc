<?php if(isAjax()):?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">选择客户</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-12">
        <form class="form-inline" id="one_goods_modal_table_search">
        <div class="form-group">
        <select size="1" class="form-control" name="shop_id">
        <option value="">---</option>
        <?php foreach($my_shop as $key=>$val):?>
        <option value="<?php echo $key?>"><?php echo $val?></option>
        <?php endforeach?>
        </select>
        <input type="text" name="kw" class="form-control" placeholder="商品名...">
        <input type="submit" class="btn" value="搜索"/>
        </div>
        </form>
        </div>				
        <div class="col-xs-12">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="one_goods_modal_table">
            <thead>
                <tr>
                <th style="display:none">编号</th>
                <th>店铺</th>
                <th>名称</th>
                <th>联系人</th>
                <th>电话</th>
                <th>欠款</th>
                <th>消费</th>
                <th>优惠</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
        <div class="col-xs-4 text-left"><label class="control-label" id="one_goods_modal_table_info"></label></div>
        <div class="col-xs-8 text-right" id="one_goods_modal_table_page"></div>
   </div>
</div>
<!-- /.modal -->
<script type="text/javascript">
$("#one_goods_modal_table").ajaxTable({
    "loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "one_goods_modal_table_page",
    "pageInfoContainer": "one_goods_modal_table_info",
    "searchForm": "one_goods_modal_table_search",
    "perpage": 20,
	"url": '<?php echo url('CustomerPay','customer')?>',
	"columns": [
                {"name":"id", "data": "id", "attr": "style='display:none'" },
                {"name":"shop_name", "data": "shop_name"},
                {"name":"name", "data": "name"},
                {"name":"contact", "data": "contact" },
                {"name":"phone", "data": "phone" },
                {"name":"overdraft", "data": "overdraft" },
                {"name":"consume", "data": "consume" },
                {"name":"offer", "data": "offer" }
        ],
    "complete": function(cb){
        $("#one_goods_modal_table tbody tr").dblclick(function(){
            if(typeof oneGoodsModalFinish == "function") {
                oneGoodsModalFinish({
                        id:$(this).children("td:eq(0)").html(),
                        shop_name:$(this).children("td:eq(1)").html(),
                        name:$(this).children("td:eq(2)").html(),
                        contact:$(this).children("td:eq(3)").html(),
                        phone:$(this).children("td:eq(4)").html(),
                        overdraft:$(this).children("td:eq(5)").html(),
                        consume:$(this).children("td:eq(6)").html(),
                        offer:$(this).children("td:eq(7)").html()
                    });
            }                
        });
    }
});
</script>
<?php else:?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>选择客户</title>
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
                <li><a href="<?php echo url('Customer')?>">客户管理</a></li>
                <li class="active">选择客户</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>客户列表</h4>
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
							<input type="text" name="kw" class="form-control" placeholder="姓名/电话">
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
                                    <th style="display:none">编号</th>
                                    <th>店铺</th>
                                    <th>名称</th>
                                    <th>联系人</th>
                                    <th>电话</th>
                                    <th>欠款</th>
                                    <th>消费</th>
                                    <th>优惠</th>
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
<?php include 'msg_modal.php';?>
<?php include 'ajax_load.php';?>
<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript">
$(".addCustomer").click(function(){
    ajaxLoad(this.href);
    return false;
});
$(".importCustomer").click(function(){
    var url = this.href;
    $("#_table").trigger('getParams',function(d){
		window.open(url + (url.indexOf('?')>=0?'&':'?') + d);
    });
    return false;
});
$("#_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('CustomerPay','customer')?>',
	"columns": [
                {"name":"id", "data": "id", "attr": "style='display:none'" },
                {"name":"shop_name", "data": "shop_name"},
                {"name":"name", "data": "name"},
                {"name":"contact", "data": "contact" },
                {"name":"phone", "data": "phone" },
                {"name":"overdraft", "data": "overdraft" },
                {"name":"consume", "data": "consume" },
                {"name":"offer", "data": "offer" }
		],
    "complete": function(cb){
        $("#_table tbody tr").dblclick(function(){
            window.location.href='<?php echo url('CustomerPay','add')?>&id='+$(this).children("td:eq(0)").html();
        });
    }
});
</script>
</body>
</html>
<?php endif;?>