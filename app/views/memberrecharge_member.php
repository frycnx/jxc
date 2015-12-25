<?php if(isAjax()):?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">选择会员</h4>
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
        <select size="1" class="form-control" name="level_id">
        <option value="">---</option>
        <?php foreach($member_level as $key=>$val):?>
        <option value="<?php echo $key?>" discount="<?php echo $val['discount']?>"><?php echo $val['name']?></option>
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
                <th>卡号</th>                                    
                <th>姓名</th>
                <th>性别</th>
                <th>电话</th>
                <th>级别</th>
                <th>折扣</th>
                <th>预存</th>
                <th>消费</th>
                <th>积分</th>
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
    "url": '<?php echo url('MemberRecharge','member')?>',
    "columns": [
            {"name":"id", "data": "id", "attr": "style='display:none'" },
            {"name":"shop_name", "data": "shop_name"},
			{"name":"card", "data": "card"},            
			{"name":"name", "data": "name"},
			{"name":"sex", "data": function(d){if(d['sex']=='m'){return '男';}else if(d['sex']=='f'){return '女';}else{return '密';}} },
            {"name":"phone", "data": "phone" },
            {"name":"level_name", "data": "level_name" },
            {"name":"level_discount", "data": "level_discount" },
            {"name":"money", "data": "money" },
            {"name":"consume", "data": "consume" },
            {"name":"point", "data": "point" }
        ],
    "complete": function(cb){
        $("#one_goods_modal_table tbody tr").dblclick(function(){
            if(typeof oneGoodsModalFinish == "function") {
                oneGoodsModalFinish({
                        id:$(this).children("td:eq(0)").html(),
                        shop_name:$(this).children("td:eq(1)").html(),
                        card:$(this).children("td:eq(2)").html(),
                        name:$(this).children("td:eq(3)").html(),
                        sex:$(this).children("td:eq(4)").html(),
                        phone:$(this).children("td:eq(5)").html(),
                        level_name:$(this).children("td:eq(6)").html(),
                        level_discount:$(this).children("td:eq(7)").html(),
                        money:$(this).children("td:eq(8)").html(),
                        consume:$(this).children("td:eq(9)").html(),
                        point:$(this).children("td:eq(10)").html()
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
	<title>选择会员</title>
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
                <li><a href="<?php echo url('Member')?>">会员管理</a></li>
                <li><a href="<?php echo url('Member')?>">会员充值</a></li>
                <li class="active">选择会员</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>选择会员</h4>
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
                            <select size="1" class="form-control" name="level_id">
                            <option value="">---</option>
                            <?php foreach($member_level as $key=>$val):?>
                            <option value="<?php echo $key?>" discount="<?php echo $val['discount']?>"><?php echo $val['name']?></option>
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
                                    <th>店铺</th>
                                    <th>卡号</th>                                    
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>电话</th>
                                    <th>级别</th>
                                    <th>折扣</th>
                                    <th>预存</th>
                                    <th>消费</th>
                                    <th>积分</th>
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
<script type="text/javascript">
$("#_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "_table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('MemberRecharge','member')?>',
	"columns": [
            {"name":"id", "data": "id", "attr": "style='display:none'" },
            {"name":"shop_name", "data": "shop_name"},
			{"name":"card", "data": "card"},            
			{"name":"name", "data": "name"},
			{"name":"sex", "data": function(d){if(d['sex']=='m'){return '男';}else if(d['sex']=='f'){return '女';}else{return '密';}} },
            {"name":"phone", "data": "phone" },
            {"name":"level_name", "data": "level_name" },
            {"name":"level_discount", "data": "level_discount" },
            {"name":"money", "data": "money" },
            {"name":"consume", "data": "consume" },
            {"name":"point", "data": "point" }
		],
    "complete": function(cb){
        $("#_table tbody tr").dblclick(function(){
            window.location.href='<?php echo url('MemberRecharge','add')?>&id='+$(this).children("td:eq(0)").html();
        });
    }
});
</script>
</body>
</html>
<?php endif;?>