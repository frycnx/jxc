<?php if(isAjax()):?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">选择商品</h4>
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
        <div class="col-xs-12">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="one_goods_modal_table">
            <thead>
                <tr>
                <th style="display:none">编号</th>
                <th>SKU</th>
                <th>商品</th>
                <th>规格</th>
                <th>店铺</th>
                <th>分类</th>                                    
                <th>售价</th>
                <th style="display:none"></th>
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
    "url": '<?php echo url('GoodsSale','goods')?>',
    "columns": [
            {"name":"id", "data": "id", "attr": "style='display:none'" },
            {"name":"sku", "data": "sku"},
            {"name":"name", "data": "name"},
            {"name":"spec", "data": "spec" },
            {"name":"shop_name", "data": "shop_name" },
            {"name":"cate_name", "data": "cate_name" },
            {"name":"price_sell", "data": "price_sell" },
            {"name":"shop_id", "data": "shop_id", "attr": "style='display:none'" }
        ],
    "complete": function(cb){
        $("#one_goods_modal_table tbody tr").dblclick(function(){
            if(typeof oneGoodsModalFinish == "function") {
                oneGoodsModalFinish({
                        id:$(this).children("td:eq(0)").html(),
                        sku:$(this).children("td:eq(1)").html(),
                        name:$(this).children("td:eq(2)").html(),
                        spec:$(this).children("td:eq(3)").html(),
                        shop_name:$(this).children("td:eq(4)").html(),
                        cate_name:$(this).children("td:eq(5)").html(),
                        price_sell:$(this).children("td:eq(6)").html(),
                        shop_id:$(this).children("td:eq(7)").html(),
                        discount:'1'
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
	<title>商品信息</title>
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
                <li class="active">选择商品</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-sm-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>选择商品</h4>
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
                                        <th style="display:none">编号</th>
                                        <th>SKU</th>
                                        <th>商品</th>
                                        <th>规格</th>
                                        <th>店铺</th>
                                        <th>分类</th>                                    
                                        <th>售价</th>
                                        <th style="display:none"></th>
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
<script type="text/javascript" src="static/js/jquery.form.js"></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<?php include 'ajax_load.php';?>
<script type="text/javascript">
$("#_table").ajaxTable({
    "loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "_table_page",
    "pageInfoContainer": "_table_info",
    "searchForm": "_table_search",
    "url": '<?php echo url('GoodsSale','goods')?>',
    "columns": [
            {"name":"id", "data": "id", "attr": "style='display:none'" },
            {"name":"sku", "data": "sku"},
            {"name":"name", "data": "name"},
            {"name":"spec", "data": "spec" },
            {"name":"shop_name", "data": "shop_name" },
            {"name":"cate_name", "data": "cate_name" },
            {"name":"price_sell", "data": "price_sell" },
            {"name":"shop_id", "data": "shop_id", "attr": "style='display:none'" }
        ],
    "complete": function(cb){
        $("#_table tbody tr").dblclick(function(){
            window.location.href='<?php echo url('GoodsSale','add')?>&id='+$(this).children("td:eq(0)").html()+'&shop_id='+$(this).children("td:eq(7)").html();
        });
    }
});
</script>
</body>
</html>
<?php endif;?>