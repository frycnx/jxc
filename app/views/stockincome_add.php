<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新增入库</title>
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
                <li class="active">新增入库</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>新增入库</h4>
                            <div class="options">
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <a href='<?php echo url('StockIncome')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 入库列表  </span></a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
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
                                  <span class="input-group-addon">类型</span>
                                  <select size="1" class="form-control" name="type" id="type">
                                  <option value="">---</option>
                                  <option value="1" <?php echo $row['type']=='1'?'selected="selected"':''?>>采购进货</option>
                                  <option value="2" <?php echo $row['type']=='2'?'selected="selected"':''?>>商品报溢</option>
                                  <option value="3" <?php echo $row['type']=='3'?'selected="selected"':''?>>商品还货</option>
                                  <option value="4" <?php echo $row['type']=='4'?'selected="selected"':''?>>其他入库</option>
                                  </select>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">操作员</span>
                                  <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $row['user_name']?>" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="col-xs-4 text-right">
                                <?php if($row['status']=='0'):?>
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <a class="btn btn-sky" data-toggle="modal"  data-target="#multi_goods_modal" data-backdrop="static" title="添加商品"><i class="fa fa-plus"></i><span class="hidden-sm"> 添加商品  </span></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn btn-sky" onclick="save(this)" title="保存单据"><i class="fa fa-save"></i><span class="hidden-sm"> 保存单据  </span></a>
                                </div>
                                </div>
                                <?php endif;?>
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
<?php include 'stockincome_goods_multi.php';?>
<script type="text/javascript">
window.onbeforeunload = function(){
    if($("#_table tbody tr").length) {
        return "离开本页则未完成的单据会自动挂账！";
    }
};
function multiGoodsModalFinish(data){
    for(var i=0; i<data.length; i++) {
        addGoods(data[i],(data.length-1) == i);
    }
}
function check(){
    if(!$('#shop_id').val()) {
        showMsg('请先选择店铺！');
        return false;
    }
    if(!$('#type').val()) {
        showMsg('请选择类型！');
        return false;
    }
    return true;
}
function save(){
    if(!check()) {
        return false;
    }
    $.post('<?php echo url('StockIncome','save')?>',{
        sn:'<?php echo $row['sn']?>',
        type:$("#type").val(),
        shop_id:$("#shop_id").val(),
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
    if(!check()) {
        return false;
    }
    $.post('<?php echo url('StockIncome','addGoods')?>',{
        goods_id:d['id'],
        discount:d['discount'],
        amount:d['amount'],            
        price:d['price'],
        sn:'<?php echo $row['sn']?>',
        type:$("#type").val(),
        shop_id:$("#shop_id").val(),
        memo:$("#memo").val()
    },function(r){
        if( last ) {
            loadGoods();
        }
    });
}
function delGoods(id){
    $.get('<?php echo url('StockIncome','delGoods')?>&id='+id,function(){loadGoods();});
}
<?php else:?>
<script type="text/javascript">
<?php endif;?>
loadGoods();
function loadGoods(){
    $.getJSON('<?php echo url('StockIncome','getGoods',array('sn'=>$row['sn']))?>',function(d){
        var table = $("#_table tbody");
        var tr='',amount=0,total=0;
        for(var i=0; i<d.length; i++) {            
            tr += '<tr>';            
            tr += '<td>' + d[i]['goods_id'] + '</td>';
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
        $("#_table tfoot tr:first th:eq(2)").html(total);
    });
}
</script>
</body>
</html>