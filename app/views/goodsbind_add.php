<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新增捆绑</title>
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
                <li class="active">新增捆绑</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>新增捆绑</h4>
							<div class="options">
								<div class="btn-toolbar">
								<div class="btn-group">
									<a href='<?php echo url('GoodsBind')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 捆绑列表  </span></a>
								</div>
								</div>
							</div>
                        </div>
                        <div class="panel-body">
                            <form method="post" class="form-horizontal" id="goods_form">
                            <fieldset>
                            <div class="row form-group">
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">单号</span>
                                  <input type="text" class="form-control" name="sn" id="sn" value="<?php echo $row['sn']?>" readonly="readonly"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">店铺</span>
                                    <select size="1" class="form-control" name="shop_id" id="shop_id" required="required">
                                    <option value="">---</option>
                                    <?php foreach($my_shop as $key=>$val):?>
                                    <option value="<?php echo $key?>"<?php echo $key==$row['shop_id']?' selected="selected"':''?>><?php echo $val?></option>
                                    <?php endforeach?>
                                    </select>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">操作员</span>
                                  <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $row['user_name']?>" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <?php if($row['status']=='0'):?>
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <a class="btn btn-sky" onclick="save(this)" title=""><i class="fa fa-save"></i><span class="hidden-sm"> 保存单据  </span></a>
                                </div>
                                </div>
                                <?php endif;?>
							</div>
                            </div>
                            </fieldset>
                            <fieldset>
                            <legend>捆绑商品 <div class="btn-group pull-right">
                                    <?php if($row['status']=='0'):?>
                                    <a class="btn btn-sky" data-toggle="modal"  data-target="#one_goods_modal" data-backdrop="static"><i class="fa fa-plus"></i><span class="hidden-sm"> 添加商品(F2)  </span></a>
                                    <?php endif;?>
                                </div></legend>
                            <div class="row form-group">
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">SKU</span>
                                  <input type="hidden" name="bind_goods_id" id="bind_goods_id" value="<?php echo $row['goods_id']?>"/>
                                  <input type="text" name="bind_goods_sku" id="bind_goods_sku" class="form-control" readonly="readonly" value="<?php echo $row['goods_sku']?>"/>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">商品</span>
                                  <input type="text" name="bind_goods_name" id="bind_goods_name" class="form-control" readonly="readonly" value="<?php echo $row['goods_name']?>"/>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">规格</span>
                                  <input type="text" name="bind_goods_spec" id="bind_goods_spec" class="form-control" readonly="readonly" value="<?php echo $row['goods_spec']?>"/>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">数量</span>
                                  <input type="text" name="bind_goods_amount" id="bind_goods_amount" class="form-control" value="<?php echo $row['goods_amount']?>"/>
                                </div>
							</div>
                            </div>
                            </fieldset>
                            <fieldset>
                            <legend>捆绑为 <div class="btn-group pull-right">
                                    <?php if($row['status']=='0'):?>
                                    <a class="btn btn-sky" data-toggle="modal"  data-target="#multi_goods_modal" data-backdrop="static"><i class="fa fa-plus"></i><span class="hidden-sm"> 添加商品(F2)  </span></a>
                                    <?php endif;?>
                                </div></legend>
                            <div class="row">
                            <div class="col-xs-12">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="_table">
                                <thead>
                                    <tr>                                    
                                    <th>SKU</th>
                                    <th>商品</th>
                                    <th>规格</th>
                                    <th>单位</th>
                                    <th>价格</th>
                                    <th>数量</th>
                                    <th>总额</th>
                                    <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th colspan="5" class="text-left">合计</th>
                                    <th>0</th>
                                    <th>0.00</th>
                                    <th></th>
                                    </tr>
                                </tfoot>
                            </table>
							</div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">备注</span>
                                  <input type="text" name="memo" id="memo" class="form-control" value="<?php echo $row['memo']?>"/>
                                </div>
							</div>
                            </div>
                            </fieldset>
                            </form>
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
<?php if($row['status']=='0'):?>
<?php include 'goodsbind_goods_one.php';?>
<?php include 'goodsbind_goods_multi.php';?>
<script type="text/javascript">
window.onbeforeunload = function(){
    if($("#_table tbody tr").length||$("#split_goods_id").val()) {
        return "离开本页则未完成的单据会自动挂账！";
    }
};
<?php else:?>
<script type="text/javascript">
<?php endif;?>
loadGoods();
function oneGoodsModalFinish(data){
    $("#bind_goods_id").val(data['id']);
    $("#bind_goods_sku").val(data['sku']);
    $("#bind_goods_name").val(data['name']);
    $("#bind_goods_spec").val(data['spec']);
    $.post('<?php echo url('GoodsBind','add')?>',{
        sn:'<?php echo $row['sn']?>',
        goods_id:data['id'],
        shop_id:$("#shop_id").val(),
        memo:$("#memo").val()
    },function(){
        $("#bind_goods_amount").focus();
    });
}
function multiGoodsModalFinish(data){
    for(var i=0; i<data.length; i++) {
        addGoods(data[i],(data.length-1) == i);
    }
}
function save(){
    $.post('<?php echo url('GoodsBind','save')?>',{
        sn:'<?php echo $row['sn']?>',
        shop_id:$("#shop_id").val(),
        goods_id:$("#bind_goods_id").val(),
        goods_amount:$("#bind_goods_amount").val(),
        memo:$("#memo").val()
    },function(r){
        showMsg(r['info']);
        if(r['state']) {
            window.onbeforeunload = null;
            window.location.reload();
        }
    },'json');
}
function addGoods(d, last){
    $.post('<?php echo url('GoodsBind','addGoods')?>',{
        id:d['id'],
        discount:d['discount'],
        amount:d['amount'],            
        price:d['price'],
        sn:'<?php echo $row['sn']?>',
        shop_id:$("#shop_id").val(),
        goods_id:$("#bind_goods_id").val(),
        goods_amount:$("#bind_goods_amount").val(),
        memo:$("#memo").val()
    },function(r){
        if( last ) {
            loadGoods();
        }
    });
}
function loadGoods(){
    $.getJSON('<?php echo url('GoodsBind','getGoods',array('sn'=>$row['sn']))?>',function(d){
        var table = $("#_table tbody");
        var tr='',amount=0,total=0;
        for(var i=0; i<d.length; i++) {            
            tr += '<tr>';
            tr += '<td>' + d[i]['goods_sku'] + '</td>';
            tr += '<td>' + d[i]['goods_name'] + '</td>';
            tr += '<td>' + d[i]['goods_spec'] + '</td>';
            tr += '<td>' + d[i]['goods_unit'] + '</td>';
            tr += '<td>' + d[i]['price'] + '</td>';
            tr += '<td>' + d[i]['amount'] + '</td>';
            tr += '<td>' + d[i]['total'] + '</td>';
            tr += '<td><div class="btn-group"><a style="cursor:pointer" onclick="delGoods(\'' + d[i]['id'] + '\')" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div></td>';
            tr += '</tr>';
            amount += parseFloat(d[i]['amount']);
            total += parseFloat(d[i]['total']);
        }
        table.html(tr);
        $("#_table tfoot tr:first th:eq(1)").html(amount);
        $("#_table tfoot tr:first th:eq(2)").html(total);
    });
}
function delGoods(id){
    $.get('<?php echo url('GoodsBind','delGoods')?>&id='+id,function(){loadGoods();});
}
</script>
</body>
</html>