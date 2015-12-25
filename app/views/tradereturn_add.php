<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新增退货</title>
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
                <li><a href="index.php">批发管理</a></li>
                <li class="active">新增退货</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>新增退货</h4>
							<div class="options">
								<div class="btn-toolbar">
								<div class="btn-group">
									<a href='<?php echo url('TradeReturn')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 退货列表  </span></a>
								</div>
								</div>
							</div>
                        </div>
                        <div class="panel-body">
                            <div class="row form-group">
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">单号</span>
                                  <input type="text" class="form-control" name="sn" id="sn" value="<?php echo $row['sn']?>" disabled="disabled"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">店铺</span>
                                    <select size="1" class="form-control" name="shop_id" id="shop_id" required="required">
                                    <option value="">---</option>
                                    <?php foreach($my_shop as $key=>$val):?>
                                    <option value="<?php echo $key?>"<?php echo $row['shop_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
                                    <?php endforeach?>
                                    </select>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">操作员</span>
                                  <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $row['user_name']?>" disabled="disabled"/>
                                </div>
                            </div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">员工</span>
                                  <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $row['user_name']?>" disabled="disabled"/>
                                </div>
                            </div>
                            <div class="col-xs-4 text-right">
                                <?php if($row['status']=='0'):?>
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <a class="btn btn-sky" data-toggle="modal"  data-target="#customer_modal" data-backdrop="static"><i class="fa fa-plus"></i><span class="hidden-sm"> 客户  </span></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-sky" data-toggle="modal"  data-target="#multi_goods_modal" data-backdrop="static"><i class="fa fa-plus"></i><span class="hidden-sm"> 商品  </span></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-sky" onclick="save(this)"><i class="fa fa-save"></i><span class="hidden-sm"> 保存  </span></a>
                                </div>
                                </div>
                                <?php endif;?>
							</div>
                            </div>
                            <div class="row form-group">
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">客户名称</span>
                                  <input type="hidden" name="customer_id" id="customer_id">
                                  <input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $row['customer_name']?>" disabled="disabled"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">联系人</span>
                                  <input type="text" class="form-control" name="customer_contact" id="customer_contact" value="<?php echo $row['customer_contact']?>" disabled="disabled"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">累计消费</span>
                                  <input type="text" class="form-control" name="customer_consume" id="customer_consume" value="<?php echo $row['customer_consume']?>" disabled="disabled"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">预付金额</span>
                                  <input type="text" class="form-control" name="customer_money" id="customer_money" value="<?php echo $row['customer_money']?>" disabled="disabled"/>
                                </div>
                            </div>
                            <div class="col-xs-2 text-right">
                                <div class="input-group">
                                  <span class="input-group-addon">优惠金额</span>
                                  <input type="text" class="form-control" name="customer_offer" id="customer_offer" value="<?php echo $row['customer_offer']?>" disabled="disabled"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-right">
                                <div class="input-group">
                                  <span class="input-group-addon">欠款金额</span>
                                  <input type="text" class="form-control" name="customer_overdraft" id="customer_overdraft" value="<?php echo $row['customer_overdraft']?>" disabled="disabled"/>
                                </div>
							</div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="_table">
                                <thead>
                                    <tr>                                    
                                    <th>编号</th>
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
                            <div class="row form-group">
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">应收</span>
                                  <input type="text" name="ysje" id="ysje" class="form-control" value="<?php echo $row['ysje']?>"/>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">实收</span>
                                  <input type="text" name="ssje" id="ssje" class="form-control" value="<?php echo $row['ssje']?>"/>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">优惠</span>
                                  <input type="text" name="yhje" id="yhje" class="form-control" value="<?php echo $row['yhje']?>"/>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">欠款</span>
                                  <input type="text" name="qkje" id="qkje" class="form-control" value="<?php echo $row['qkje']?>" disabled="disabled"/>
                                </div>
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
<?php include 'tradereturn_goods_multi.php';?>
<?php include 'tradereturn_customer.php';?>
<script type="text/javascript">
window.onbeforeunload = function(){if($("#_table tbody tr").length||$("#member_id").val()){return "离开本页则未完成的单据会自动挂账！";}};
$("#yhje").change(function(){ $("#qkje").val(subtract(subtract(parseFloat($("#ysje").val()||0),parseFloat($("#ssje").val()||0)),parseFloat($("#yhje").val()||0)));});
$("#ssje").change(function(){ $("#qkje").val(subtract(subtract(parseFloat($("#ysje").val()||0),parseFloat($("#ssje").val()||0)),parseFloat($("#yhje").val()||0)));});
$("#shop_id").change(function(){$.get('<?php echo url('Trade','delGoods')?>',{sn:'<?php echo $row['sn']?>'},function(){loadGoods()});});
function multiGoodsModalFinish(data){
    for(var i=0; i<data.length; i++) {
        addGoods(data[i],(data.length-1) == i);
    }
}
function customerModalFinish(data) {
    $('#customer_id').val(data['id']);
    $('#customer_name').val(data['name']);
    $('#customer_contact').val(data['contact']);
    $('#customer_consume').val(data['consume']);
    $('#customer_money').val(data['money']);
    $('#customer_offer').val(data['offer']);
    $('#customer_overdraft').val(data['overdraft']);
    $.post('<?php echo url('TradeReturn','addCustomer')?>',{
        customer_id:data['id'],
        customer_name:data['name'],
        customer_contact:data['contact'],
        customer_consume:data['consume'],
        customer_money:data['money'],
        customer_offer:data['offer'],
        customer_overdraft:data['overdraft'],
        sn:'<?php echo $row['sn']?>',
        shop_id:$('#shop_id').val(),
        memo:$("#memo").val()
    });
}
function save(){
    $.post('<?php echo url('TradeReturn','save')?>',{
        sn:'<?php echo $row['sn']?>',
        shop_id:$('#shop_id').val(),
        customer_id:$('#customer_id').val(),
        customer_name:$('#customer_name').val(),
        customer_contact:$('#customer_contact').val(),
        customer_consume:$('#customer_consume').val(),
        customer_money:$('#customer_money').val(),
        customer_offer:$('#customer_offer').val(),
        customer_overdraft:$('#customer_overdraft').val(),
        ysje:$("#ysje").val(),
        ssje:$("#ssje").val(),
        yhje:$("#yhje").val(),
        qkje:$("#qkje").val(),
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
    $.post('<?php echo url('TradeReturn','addGoods')?>',{
        goods_id:d['id'],
        discount:d['discount'],
        amount:d['amount'],            
        price:d['price'],
        sn:'<?php echo $row['sn']?>',
        shop_id:$('#shop_id').val(),
        customer_id:$('#customer_id').val(),
        customer_name:$('#customer_name').val(),
        customer_contact:$('#customer_contact').val(),
        customer_consume:$('#customer_consume').val(),
        customer_money:$('#customer_money').val(),
        customer_offer:$('#customer_offer').val(),
        customer_overdraft:$('#customer_overdraft').val(),
        ysje:$("#ysje").val(),
        ssje:$("#ssje").val(),
        yhje:$("#yhje").val(),
        qkje:$("#qkje").val(),
        memo:$("#memo").val()
    },function(r){
        if( last ) {
            loadGoods();
        }
    });
}
function delGoods(id){
    $.get('<?php echo url('TradeReturn','delGoods')?>&id='+id,function(){loadGoods();});
}
<?php else:?>
<script type="text/javascript">
<?php endif;?>
loadGoods();
function loadGoods(){
    $.getJSON('<?php echo url('TradeReturn','getGoods',array('sn'=>$row['sn']))?>',function(d){
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
            <?php if($row['status']=='0'):?>
            tr += '<td><div class="btn-group"><a style="cursor:pointer" onclick="delGoods(\'' + d[i]['id'] + '\')" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div></td>';
            <?php else:?>
            tr += '<td></td>';
            <?php endif;?>
            tr += '</tr>';
            amount += parseFloat(d[i]['amount']);
            total += parseFloat(d[i]['total']);
        }
        table.html(tr);
        $("#_table tfoot tr:first th:eq(1)").html(amount);
        $("#_table tfoot tr:first th:eq(2)").html(total.toFixed(2));
        $("#ysje").val(total.toFixed(2));
    });
}

</script>
</body>
</html>