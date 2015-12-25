<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="user_form">
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
		<?php if(empty($row['id'])):?>
            <select size="1" class="form-control" name="shop_id" id="form_shop_id">
            <option value="">---</option>
            <?php foreach($my_shop as $key=>$val):?>
            <option value="<?php echo $key?>"<?php echo $row['shop_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
            <?php endforeach?>
            </select>
		<?php else:?>
			<input type="hidden" name="shop_id" id="form_shop_id" value="<?php echo $row['shop_id']?>" required="required">
			<input type="text" name="shop_name" id="form_shop_name" class="form-control" value="<?php echo $row['shop_name']?>"<?php echo $row['id']?' readonly="readonly"':''?>/>
		<?php endif;?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">用户</label>
        <div class="col-sm-6">
            <input type="text" name="username" id="form_username" class="form-control" value="<?php echo $row['username']?>" required="required"<?php echo $row['id']?' readonly="readonly"':''?>/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">密码</label>
        <div class="col-sm-6">
            <input type="password" name="password" id="form_password" class="form-control"<?php echo $row['_password']?' required="required"':''?>/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">确认密码</label>
        <div class="col-sm-6">
            <input type="password" name="repassword" id="form_repassword" class="form-control"<?php echo $row['_password']?' required="required"':''?>/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">姓名</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="form_name" class="form-control" value="<?php echo $row['name']?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">电话</label>
        <div class="col-sm-6">
            <input type="text" name="phone" id="form_phone" class="form-control" value="<?php echo $row['phone']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">邮箱</label>
        <div class="col-sm-6">
            <input type="text" name="email" id="form_email" class="form-control" value="<?php echo $row['email']?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">角色</label>
        <div class="col-sm-6">
            <select size="1" class="form-control" name="role_id" id="form_role_id">
            <option value="">---</option>
            <?php foreach($role as $key=>$val):?>
            <option value="<?php echo $key?>"<?php echo $row['role_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
            <?php endforeach?>
            </select>
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
    $('#user_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('#form_shop_id').val()=='') {
                showError('店铺不能为空！');
                return false;
            }
            if($('#form_username').val()=='') {
                showError('用户名不能为空！');
                return false;
            }
            <?php if($row['_password']):?>
            if($('#form_password').val()=='') {
                showError('密码不能为空！');
                return false;
            }
            if($('#form_repassword').val()=='') {
                showError('确认密码不能为空！');
                return false;
            }
            if($('#form_repassword').val()!=$('#form_password').val()) {
                showError('两次密码不一致！');
                return false;
            }
            <?php endif;?>
            if($('#form_name').val()=='') {
                showError('姓名不能为空！');
                return false;
            }
            if($('#form_role_id').val()=='') {
                showError('角色不能为空！');
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
                $("#user_form").parent().parent().find(".close").click();
                $("#_table").trigger('ajaxLoad');
            } else {
                showError(d.info);
            }
        }
    });
    <?php if(empty($row['id'])):?>
    $("#form_username").focus();
	<?php else:?>
	$("#form_name").select();
    <?php endif;?>
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
                <li>系统管理</li>
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
                        <a href='<?php echo url('User')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 用户列表  </span></a>
                    </div>
                </div>
            </div>
            <form method="post" class="form-horizontal row-border" id="user_form">
            <?php if(!empty($row['id'])):?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
			<?php echo inputHash();?>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">店铺</label>
                    <div class="col-sm-6">
					<?php if(empty($row['id'])):?>
						<select size="1" class="form-control" name="shop_id" id="form_shop_id">
						<option value="">---</option>
						<?php foreach($my_shop as $key=>$val):?>
						<option value="<?php echo $key?>"<?php echo $row['shop_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
						<?php endforeach?>
						</select>
					<?php else:?>
						<input type="hidden" name="shop_id" id="form_shop_id" value="<?php echo $row['shop_id']?>" required="required">
						<input type="text" name="shop_name" id="form_shop_name" class="form-control" value="<?php echo $row['shop_name']?>"<?php echo $row['id']?' readonly="readonly"':''?>/>
					<?php endif;?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">用户</label>
                    <div class="col-sm-6">
                        <input type="text" name="username" id="form_username" required="required" class="form-control" value="<?php echo $row['username']?>"<?php echo $row['id']?' readonly="readonly"':''?>/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">密码</label>
                    <div class="col-sm-6">
                        <input type="text" name="password" id="form_password"<?php echo $row['_password']?' required="required"':''?> class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">确认密码</label>
                    <div class="col-sm-6">
                        <input type="text" name="repassword" id="form_repassword"<?php echo $row['_password']?' required="required"':''?> class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">姓名</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="form_name" required="required" class="form-control" value="<?php echo $row['name']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">电话</label>
                    <div class="col-sm-6">
                        <input type="text" name="phone" id="form_phone" class="form-control" value="<?php echo $row['phone']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">邮箱</label>
                    <div class="col-sm-6">
                        <input type="text" name="email" id="form_email" class="form-control" value="<?php echo $row['email']?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">角色</label>
                    <div class="col-sm-6">
                        <select size="1" class="form-control" name="role_id" id="form_role_id">
                        <option value="">---</option>
                        <?php foreach($role as $key=>$val):?>
                        <option value="<?php echo $key?>"<?php echo $row['role_id']==$key?' selected="selected"':''?>><?php echo $val?></option>
                        <?php endforeach?>
                        </select>
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
<script type='text/javascript' src='static/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript"><?php if(empty($row['id'])):?>$("#form_username").focus();<?php else:?>$("#form_name").select();<?php endif;?>
</script>
</body>
</html>
<?php endif?>