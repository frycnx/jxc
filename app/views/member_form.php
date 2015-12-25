<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="member_form">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo $title?></h4>
</div>
<div class="modal-body">
    <?php if(!empty($row['id'])):?>
    <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
    <?php endif;?>
    <?php echo inputHash();?>
    <div class="form-group">
        <label class="col-sm-3 control-label">店铺</label>
        <div class="col-sm-6">
            <select size="1" class="form-control" name="shop_id" id="form_shop_id" required="required">
            <option value="">---</option>
            <?php foreach($my_shop as $key=>$val):?>
            <option value="<?php echo $key?>"<?php echo $key==$row['shop_id']?' selected="selected"':''?>><?php echo $val?></option>
            <?php endforeach?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">卡号</label>
        <div class="col-sm-6">
            <input type="text" name="card" id="form_card" class="form-control" value="<?php echo $row['card']?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">姓名</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="form_name" class="form-control" value="<?php echo $row['name']?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">性别</label>
        <div class="col-sm-6">
            <label class="radio-inline">
              <input type="radio" name="sex" value="1" <?php echo $row['sex']=='1'?'checked="checked"':''?> data-group="sex"/> 男
            </label>
            <label class="radio-inline">
              <input type="radio" name="sex" value="0" <?php echo $row['sex']=='0'?'checked="checked"':''?> data-group="sex"/> 女
            </label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">生日</label>
        <div class="col-sm-6">
            <input type="text" name="birth" id="form_birth" class="form-control" value="<?php echo $row['birth']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">电话</label>
        <div class="col-sm-6">
            <input type="text" name="phone" id="form_phone" class="form-control" value="<?php echo $row['phone']?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">地址</label>
        <div class="col-sm-6">
            <input type="text" name="address" id="form_address" class="form-control" value="<?php echo $row['address']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">级别</label>
        <div class="col-sm-6">
            <select size="1" class="form-control" name="level_id" id="form_level_id" required="required">
            <option value="">---</option>
            <?php foreach($member_level as $key=>$val):?>
            <option value="<?php echo $key?>" discount="<?php echo $val['discount']?>"<?php echo $key==$row['level_id']?' selected="selected"':''?>><?php echo $val['name']?></option>
            <?php endforeach?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">折扣</label>
        <div class="col-sm-6">
            <input type="text" name="discount" id="form_discount" class="form-control" value="<?php echo $row['level_discount']?>" required="required"/>
        </div>
    </div>
    <?php if($row['from_act']=='add'):?>
    <div class="form-group">
        <label class="col-sm-3 control-label">预存</label>
        <div class="col-sm-6">
            <input type="text" name="money" id="form_money" class="form-control" value="0.00"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">消费</label>
        <div class="col-sm-6">
            <input type="text" name="consume" id="form_consume" class="form-control" value="0.00"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">积分</label>
        <div class="col-sm-6">
            <input type="text" name="point" id="form_point" class="form-control" value="0.00"/>
        </div>
    </div>
    <?php endif;?>
    <div class="form-group">
        <label class="col-sm-3 control-label">密码</label>
        <div class="col-sm-6">
            <input type="password" name="password" id="form_password" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">备注</label>
        <div class="col-sm-6">
            <input type="text" name="memo" id="form_memo" class="form-control" value="<?php echo $row['memo']?>"/>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
    <button type="submit" class="btn btn-primary" name="submit">确定</button>
</div>
</form>
<script type="text/javascript">
    $('#member_form').ajaxForm({
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
                $("#member_form").parent().parent().find(".close").click();
                $("#_table").trigger('ajaxLoad');
            } else {
                showError(d.info);
            } 
        }
    });
    $("#form_level_id").change(function(){$('#form_discount').val($(this).find('option:selected').attr('discount'));});
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
                <li>会员管理</li>
                <li><a href="<?php echo url('Member')?>">会员信息</a></li>
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
						<a href='<?php echo url('Member')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 会员信息  </span></a>
					</div>
				</div>
			</div>
            <form action="<?php echo $action?>" method="post" class="form-horizontal row-border" id="member_form">
            <?php if(!empty($row['id'])):?>
            <input type="hidden" name="id" id="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
            <?php echo inputHash();?>
            <div class="panel-body">                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">店铺</label>
                        <div class="col-sm-6">
                            <select size="1" class="form-control" name="shop_id" id="form_shop_id" required="required">
                            <option value="">---</option>
                            <?php foreach($my_shop as $key=>$val):?>
                            <option value="<?php echo $key?>"<?php echo $key==$row['shop_id']?' selected="selected"':''?>><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">卡号</label>
                        <div class="col-sm-6">
                            <input type="text" name="card" id="form_card" class="form-control" value="<?php echo $row['card']?>" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">姓名</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="form_name" class="form-control" value="<?php echo $row['name']?>" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">性别</label>
                        <div class="col-sm-6">
							<label class="radio-inline">
							  <input type="radio" name="sex" value="1" <?php echo $row['sex']=='1'?'checked="checked"':''?> data-group="sex"/> 男
							</label>
							<label class="radio-inline">
							  <input type="radio" name="sex" value="0" <?php echo $row['sex']=='0'?'checked="checked"':''?> data-group="sex"/> 女
							</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">生日</label>
                        <div class="col-sm-6">
                            <input type="text" name="birth" id="form_birth" class="form-control" value="<?php echo $row['birth']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">电话</label>
                        <div class="col-sm-6">
                            <input type="text" name="phone" id="form_phone" class="form-control" value="<?php echo $row['phone']?>" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">地址</label>
                        <div class="col-sm-6">
                            <input type="text" name="address" id="form_address" class="form-control" value="<?php echo $row['address']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">级别</label>
                        <div class="col-sm-6">
                            <select size="1" class="form-control" name="level_id" id="form_level_id" required="required">
                            <option value="">---</option>
                            <?php foreach($member_level as $key=>$val):?>
                            <option value="<?php echo $key?>" discount="<?php echo $val['discount']?>"<?php echo $key==$row['level_id']?' selected="selected"':''?>><?php echo $val['name']?></option>
                            <?php endforeach?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">折扣</label>
                        <div class="col-sm-6">
                            <input type="text" name="discount" id="form_discount" class="form-control" value="<?php echo $row['level_discount']?>" required="required"/>
                        </div>
                    </div>
                    <?php if($row['from_act']=='add'):?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">预存</label>
                        <div class="col-sm-6">
                            <input type="text" name="money" id="form_money" class="form-control" value="0.00"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">消费</label>
                        <div class="col-sm-6">
                            <input type="text" name="consume" id="form_consume" class="form-control" value="0.00"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">积分</label>
                        <div class="col-sm-6">
                            <input type="text" name="point" id="form_point" class="form-control" value="0.00"/>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="password" id="form_password" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>
                        <div class="col-sm-6">
                            <input type="text" name="memo" id="form_memo" class="form-control" value="<?php echo $row['memo']?>"/>
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
<script type="text/javascript">$("#form_level_id").change(function(){$('#form_discount').val($(this).find('option:selected').attr('discount'));});$("#form_name").select();</script>
</body>
</html>
<?php endif;?>