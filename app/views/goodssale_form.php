<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="goodssale_form">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">新增特价</h4>
</div>
<div class="modal-body">
    <?php if(!empty($row['id'])):?>
    <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
    <?php endif;?>
    <?php echo inputHash();?>
    <div class="form-group">
        <label class="col-sm-3 control-label">SKU</label>
        <div class="col-sm-6">
            <input type="hidden" name="goods_id" value="<?php echo $row['goods_id']?>"/>
            <input type="text" name="goods_sku" id="form_goods_sku" required="required" readonly="readonly" class="form-control" value="<?php echo $row['goods_sku']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">名称</label>
        <div class="col-sm-6">
            <input type="text" name="goods_name" id="form_goods_name" readonly="readonly" class="form-control" value="<?php echo $row['name']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">规格</label>
        <div class="col-sm-6">
            <input type="text" name="goods_spec" id="form_goods_spec" readonly="readonly" class="form-control" value="<?php echo $row['spec']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">单位</label>
        <div class="col-sm-6">
            <input type="text" name="goods_unit" id="form_goods_unit" readonly="readonly" class="form-control" value="<?php echo $row['unit']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">产地</label>
        <div class="col-sm-6">
            <input type="text" name="goods_origin" id="form_goods_origin" readonly="readonly" class="form-control" value="<?php echo $row['origin']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">条码</label>
        <div class="col-sm-6">
            <input type="text" name="barcode" id="form_goods_barcode" readonly="readonly" class="form-control" value="<?php echo $row['barcode']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">分类</label>
        <div class="col-sm-6">
            <input type="text" name="cate_name" id="form_cate_name" readonly="readonly" class="form-control" value="<?php echo $row['cate_name']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">店铺</label>
        <div class="col-sm-6">
            <input type="hidden" name="shop_id" id="form_shop_id" value="<?php echo $row['shop_id']?>"/>
            <input type="text" name="shop_name" id="form_shop_name" readonly="readonly" class="form-control" value="<?php echo $row['shop_name']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">原价</label>
        <div class="col-sm-6">
            <input type="text" name="price_sell" id="form_price_sell" readonly="readonly" class="form-control" value="<?php echo $row['price_sell']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">特价</label>
        <div class="col-sm-6">
            <input type="text" name="price_sale" id="form_price_sale" required="required" class="form-control" value="<?php echo $row['price_sale']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">会员价</label>
        <div class="col-sm-6">
            <input type="text" name="price_member" id="form_price_member" required="required" class="form-control" value="<?php echo $row['price_member']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">期限</label>
        <div class="col-sm-6">
            <label class="radio-inline">
                <input type="radio" name="qx" value="a" <?php echo $row['sale_time_type']=='a'?'checked="checked"':''?> data-group="qx" required="required"/> 无限期
            </label>
            <label class="radio-inline">
              <input type="radio" name="qx" value="t" <?php echo $row['sale_time_type']=='t'?'checked="checked"':''?> data-group="qx" required="required"/> 按日期
            </label>
            <label class="radio-inline">
              <input type="radio" name="qx" value="w" <?php echo $row['sale_time_type']=='w'?'checked="checked"':''?> data-group="qx" required="required"/> 按星期
            </label>
            <div id="riqi" style="display:none">
              <label>
              <input type="text" placeholder="开始日期" name="riqi_start" id="riqi_start" class="form-control"/>
              </label>
              -
              <label>
              <input type="text" placeholder="结束日期" name="riqi_end" id="riqi_end" class="form-control"/>
              </label>
            </div>
            <div id="xiqi" style="display:none">
              <label><input type="checkbox" name="xiqi[]" value="1">周一</label>&nbsp;
              <label><input type="checkbox" name="xiqi[]" value="2">周二</label>&nbsp;
              <label><input type="checkbox" name="xiqi[]" value="3">周三</label>&nbsp;
              <label><input type="checkbox" name="xiqi[]" value="4">周四</label>&nbsp;
              <label><input type="checkbox" name="xiqi[]" value="5">周五</label>&nbsp;
              <label><input type="checkbox" name="xiqi[]" value="6">周六</label>&nbsp;
              <label><input type="checkbox" name="xiqi[]" value="0">周日</label>&nbsp;
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">状态</label>
        <div class="col-sm-6">
            <label class="radio-inline">
              <input type="radio" name="status" value="1" <?php echo $row['status']=='1'?'checked="checked"':''?> data-group="state"/> 启用
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" value="0" <?php echo $row['status']=='0'?'checked="checked"':''?> data-group="state"/> 禁用
            </label>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary" name="submit">确定</button>
</div>
</form>
<script type="text/javascript">
    $('#goodssale_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('#form_goods_sku').val()=='') {
                showMsg('SKU不能为空！');
                return false;
            }
            if($('#form_price_sale').val()==''&&$('#form_price_member').val()=='') {
                showMsg('特价与会员价不能全为空！');
                return false;
            }
            return true;
        },
        error:function(){
            showMsg('系统错误!');
        },
        success:function(d){
            if(d.state) {
                showSuccess(d.info);
                $("#goodssale_form").parent().parent().find(".close").click();
                $("#_table").trigger('ajaxLoad');
            } else {
                showError(d.info);
            } 
        }
    });
    $('input[name=qx]').click(function(){
        $('#riqi').hide();
        $('#xiqi').hide();
        $('#riqi input').removeAttr('required');
        //$('#xiqi input').removeAttr('required');
        if($(this).val() == 't') {
            $('#riqi').show();
            $('#riqi input').attr('required','required');
        } else if($(this).val()  == 'w') {
            //$('#xiqi input').attr('required','required');
            $('#xiqi').show();
        }
    });
    $('#riqi').hide();
    $('#xiqi').hide();
    $('#riqi_start').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '<?php echo date('Y-m-d')?>',
        onClose: function( d ) {$( "#riqi_end" ).datepicker( "option", "minDate", d );}
    });
    $('#riqi_end').datepicker({dateFormat: 'yy-mm-dd'});
    if('<?php echo $row['sale_time_type']?>' == 't') {
        var ar = '<?php echo $row['sale_time']?>'.split(',');
        $('#riqi_start').val(date('Y-m-d', ar[0]));
        $('#riqi_end').val(date('Y-m-d', ar[1]));
        $('#riqi').show();
    } else if('<?php echo $row['sale_time_type']?>' == 'w') {
        var ar = '<?php echo $row['sale_time']?>'.split(',');
        $('#xiqi input').each(function(){
            if($.inArray($(this).val(),ar) > -1) {
                $(this).attr('checked','checked');
            }
        });
        $('#xiqi').show();
    }
    $("#form_price_sale").select();
</script>
<?php else:?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title?></title>
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
            <ul class="breadcrumb">
                <li>商品管理</li>
                <li><a href="<?php echo url('GoodsSale')?>">商品特价</a></li>
                <li class="active"><?php echo $title?></li>
            </ul>
        </div>
<div class="container">

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-sky">
            <div class="panel-heading">
                <h4><?php echo $title?></h4>
                <div class="options">
                    <div class="btn-toolbar">
                        <a href='<?php echo url('GoodsSale')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 商品特价  </span></a>
                    </div>
                </div>
            </div>
            <form action="<?php echo $action?>" method="post" class="form-horizontal row-border" id="goodssale_form">
            <?php if(!empty($row['id'])):?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
            <?php echo inputHash();?>
            <div class="panel-body">                
                <div class="form-group">
                    <label class="col-sm-3 control-label">SKU</label>
                    <div class="col-sm-6">
                        <input type="hidden" name="goods_id" value="<?php echo $row['goods_id']?>"/>
                        <input type="text" name="goods_sku" id="form_goods_sku" required="required" readonly="readonly" class="form-control" value="<?php echo $row['goods_sku']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">名称</label>
                    <div class="col-sm-6">
                        <input type="text" name="goods_name" id="form_goods_name" readonly="readonly" class="form-control" value="<?php echo $row['name']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">规格</label>
                    <div class="col-sm-6">
                        <input type="text" name="goods_spec" id="form_goods_spec" readonly="readonly" class="form-control" value="<?php echo $row['spec']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">单位</label>
                    <div class="col-sm-6">
                        <input type="text" name="goods_unit" id="form_goods_unit" readonly="readonly" class="form-control" value="<?php echo $row['unit']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">产地</label>
                    <div class="col-sm-6">
                        <input type="text" name="goods_origin" id="form_goods_origin" readonly="readonly" class="form-control" value="<?php echo $row['origin']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">条码</label>
                    <div class="col-sm-6">
                        <input type="text" name="barcode" id="form_goods_barcode" readonly="readonly" class="form-control" value="<?php echo $row['barcode']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">分类</label>
                    <div class="col-sm-6">
                        <input type="text" name="cate_name" id="form_cate_name" readonly="readonly" class="form-control" value="<?php echo $row['cate_name']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">店铺</label>
                    <div class="col-sm-6">
                        <input type="hidden" name="shop_id" id="form_shop_id" value="<?php echo $row['shop_id']?>"/>
                        <input type="text" name="shop_name" id="form_shop_name" readonly="readonly" class="form-control" value="<?php echo $row['shop_name']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">原价</label>
                    <div class="col-sm-6">
                        <input type="text" name="price_sell" id="form_price_sell" readonly="readonly" class="form-control" value="<?php echo $row['price_sell']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">特价</label>
                    <div class="col-sm-6">
                        <input type="text" name="price_sale" id="form_price_sale" required="required" class="form-control" value="<?php echo $row['price_sale']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员价</label>
                    <div class="col-sm-6">
                        <input type="text" name="price_member" id="form_price_member" required="required" class="form-control" value="<?php echo $row['price_member']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">期限</label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                            <input type="radio" name="qx" value="a" <?php echo $row['sale_time_type']=='a'?'checked="checked"':''?> data-group="qx" required="required"/> 无限期
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="qx" value="t" <?php echo $row['sale_time_type']=='t'?'checked="checked"':''?> data-group="qx" required="required"/> 按日期
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="qx" value="w" <?php echo $row['sale_time_type']=='w'?'checked="checked"':''?> data-group="qx" required="required"/> 按星期
                        </label>
                        <div id="riqi" style="display:none">
                          <label>
                          <input type="text" placeholder="开始日期" name="riqi_start" id="riqi_start" class="form-control"/>
                          </label>
                          -
                          <label>
                          <input type="text" placeholder="结束日期" name="riqi_end" id="riqi_end" class="form-control"/>
                          </label>
                        </div>
                        <div id="xiqi" style="display:none">
                          <label><input type="checkbox" name="xiqi[]" value="1">周一</label>&nbsp;
                          <label><input type="checkbox" name="xiqi[]" value="2">周二</label>&nbsp;
                          <label><input type="checkbox" name="xiqi[]" value="3">周三</label>&nbsp;
                          <label><input type="checkbox" name="xiqi[]" value="4">周四</label>&nbsp;
                          <label><input type="checkbox" name="xiqi[]" value="5">周五</label>&nbsp;
                          <label><input type="checkbox" name="xiqi[]" value="6">周六</label>&nbsp;
                          <label><input type="checkbox" name="xiqi[]" value="0">周日</label>&nbsp;
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">状态</label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                          <input type="radio" name="status" value="1" <?php echo $row['status']=='1'?'checked="checked"':''?> data-group="state"/> 启用
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="status" value="0" <?php echo $row['status']=='0'?'checked="checked"':''?> data-group="state"/> 禁用
                        </label>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                            <input class="btn btn-primary" type="submit" value="提交">
                            <input class="btn btn-default" type="reset" value="取消">
                        </div>
                    </div>
                </div>
            </div>
            </form>
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
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript">
    $('input[name=qx]').click(function(){
        $('#riqi').hide();
        $('#xiqi').hide();
        $('#riqi input').removeAttr('required');
        //$('#xiqi input').removeAttr('required');
        if($(this).val() == 't') {
            $('#riqi').show();
            $('#riqi input').attr('required','required');
        } else if($(this).val()  == 'w') {
            //$('#xiqi input').attr('required','required');
            $('#xiqi').show();
        }
    });
    $('#riqi_start').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: '<?php echo date('Y-m-d')?>',
        onClose: function( d ) {$( "#riqi_end" ).datepicker( "option", "minDate", d );}
    });
    $('#riqi_end').datepicker({dateFormat: 'yy-mm-dd'});
    if('<?php echo $row['sale_time_type']?>' == 't') {
        var ar = '<?php echo $row['sale_time']?>'.split(',');
        $('#riqi_start').val(date('Y-m-d', ar[0]));
        $('#riqi_end').val(date('Y-m-d', ar[1]));
        $('#riqi').show();
    } else if('<?php echo $row['sale_time_type']?>' == 'w') {
        var ar = '<?php echo $row['sale_time']?>'.split(',');
        $('#xiqi input').each(function(){
            if($.inArray($(this).val(),ar) > -1) {
                $(this).attr('checked','checked');
            }
        });
        $('#xiqi').show();
    }
    $('#riqi').hide();
    $('#xiqi').hide();
    $("#form_price_sale").select();
</script>
</body>
</html>
<?php endif;?>