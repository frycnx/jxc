<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="goods_form">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">新增商品</h4>
</div>
<div class="modal-body">
    <?php echo inputHash();?>               
    <div class="form-group">
        <label class="col-sm-3 control-label">SKU</label>
        <div class="col-sm-6">
            <?php if($row['id']):?>
            <input type="hidden" name="id" id="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
            <input type="text" name="sku" id="form_sku" required="required" class="form-control" value="<?php echo $row['sku']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">名称</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="form_name" required="required" class="form-control" value="<?php echo $row['name']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">规格</label>
        <div class="col-sm-6">
            <input type="text" name="spec" id="form_spec" required="required" class="form-control" value="<?php echo $row['spec']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">单位</label>
        <div class="col-sm-6">
            <input type="text" name="unit" id="form_unit" class="form-control" value="<?php echo $row['unit']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">产地</label>
        <div class="col-sm-6">
            <input type="text" name="origin" id="form_origin" class="form-control" value="<?php echo $row['origin']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">条码</label>
        <div class="col-sm-6">
            <input type="text" name="barcode" id="form_barcode" class="form-control" value="<?php echo $row['barcode']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">分类</label>
        <div class="col-sm-6">
            <select name="cate_id" id="form_cate_id" required="required" class="form-control" data-value="<?php echo $row['cate_id']?>">
            <option value="">---</option>
            <?php foreach($category as $key=>$val):?>
            <option value="<?php echo $key?>"<?php echo $row['cate_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
            <?php endforeach?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">售价</label>
        <div class="col-sm-6">
            <?php foreach($row['stock'] as $stock):?>
            <div class="input-group">
                <span class="input-group-addon"><?php echo $stock['shop_name']?></span>
                <input type="text" name="price_sell[<?php echo $stock['shop_id']?>]" required="required" class="form-control" value="<?php echo $stock['price_sell']?>"/>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">备注</label>
        <div class="col-sm-6">
            <input type="text" name="memo" id="form_memo" class="form-control" value="<?php echo $row['memo']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">状态</label>
        <div class="col-sm-6">
            <label class="radio-inline">
              <input type="radio" name="status" value="1" <?php echo $row['status']=='1'?'checked="checked"':''?> data-group="status"/> 启用
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" value="0" <?php echo $row['status']=='0'?'checked="checked"':''?> data-group="status"/> 禁用
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
    $('#goods_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('#form_sku').val()=='') {
                showError('SKU不能为空！');
                return false;
            }
            if($('#form_name').val()=='') {
                showError('名称不能为空！');
                return false;
            }
            if($('#form_spec').val()=='') {
                showError('规格不能为空！');
                return false;
            }
            if($('#form_cate_id').val()=='') {
                showError('分类不能为空！');
                return false;
            }
            return true;
        },
        error:function(){
            showError('系统错误!');
        },
        success:function(d){
            if(d.state) {
                showSuccess(d.info);
                $("#goods_form").parent().parent().find(".close").click();
                $("#_table").trigger('ajaxLoad');
            } else {
                showError(d.info);
            } 
        }
    });
    $("#form_name").select();
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
                <li><a href="<?php echo url('Goods')?>">商品信息</a></li>
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
                        <a href='<?php echo url('Goods')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 商品分类  </span></a>
                    </div>
                </div>
            </div>
            <form action="<?php echo $action?>" method="post" class="form-horizontal row-border" id="goods_form">
            <?php if($row['id']):?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
            <?php echo inputHash();?>
            <div class="panel-body">                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">SKU</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="SKU" name="sku" id="form_sku" required="required" class="form-control" value="<?php echo $row['sku']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">名称</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="名称" name="name" id="form_name" required="required" class="form-control" value="<?php echo $row['name']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">规格</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="规格" name="spec" id="form_spec" required="required" class="form-control" value="<?php echo $row['spec']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">单位</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="单位" name="unit" id="form_unit" required="required" class="form-control" value="<?php echo $row['unit']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">产地</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="产地" name="origin" id="form_origin" required="required" class="form-control" value="<?php echo $row['origin']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">条码</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="条码" name="barcode" id="form_barcode" required="required" class="form-control" value="<?php echo $row['barcode']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">分类</label>
                        <div class="col-sm-6">
                            <select name="cate_id" id="form_cate_id" required="required" class="form-control" data-value="<?php echo $row['cate_id']?>">
                            <option value="">---</option>
                            <?php foreach($category as $key=>$val):?>
                            <option value="<?php echo $key?>"<?php echo $row['cate_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">售价</label>
                        <div class="col-sm-6">
                            <?php foreach($row['stock'] as $stock):?>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $stock['shop_name']?></span>
                                <input type="text" placeholder="售价" name="price_sell[<?php echo $stock['shop_id']?>]" required="required" class="form-control" value="<?php echo $stock['price_sell']?>"/>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="备注" name="memo" id="form_memo" class="form-control" value="<?php echo $row['memo']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>
                        <div class="col-sm-6">
							<label class="radio-inline">
							  <input type="radio" name="status" value="1" <?php echo $row['status']=='1'?'checked="checked"':''?> data-group="status"/> 启用
							</label>
							<label class="radio-inline">
							  <input type="radio" name="status" value="0" <?php echo $row['status']=='0'?'checked="checked"':''?> data-group="status"/> 禁用
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
<script type='text/javascript' src='static/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript">$("#form_name").select();</script>
</body>
</html>
<?php endif?>