<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>编辑资料</title>
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
                <li><a href="index.php">首页</a></li>
                <li class="active">编辑资料</li>
            </ul>
        </div>
<div class="container">

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-sky">
            <div class="panel-heading"><h4>编辑资料</h4></div>
            <form action="<?php echo url('Index','profile')?>" method="post" class="form-horizontal row-border" id="profie_form">
            <input type="hidden" name="user_id" value="<?php echo $row['id']?>"/>
            <div class="panel-body">  
                    <div class="form-group">
                        <label class="col-sm-3 control-label">店铺</label>
                        <div class="col-sm-6">
                            <input type="text" name="shop_name" class="form-control" value="<?php echo $row['shop_name']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">用户名</label>
                        <div class="col-sm-6">
                            <input type="text" name="username" class="form-control" value="<?php echo $row['username']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">原密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="old_password" id="old_password" placeholder="填写原密码" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">新密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="new_password" id="new_password" placeholder="至少六位密码" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">确认密码</label>
                        <div class="col-sm-6">
                            <input type="password" name="re_password" id="re_password" placeholder="至少六位密码" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">姓名</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $row['name']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">性别</label>
                        <div class="col-sm-6">
							<label class="radio-inline">
							  <input type="radio" name="sex" value="1" <?php echo $row['sex']=='1'?'checked="checked"':''?> data-group="state"/> 男
							</label>
							<label class="radio-inline">
							  <input type="radio" name="sex" value="0" <?php echo $row['sex']=='2'?'checked="checked"':''?> data-group="state"/> 女
							</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">电话</label>
                        <div class="col-sm-6">
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $row['phone']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input type="text" name="email" id="email" class="form-control" value="<?php echo $row['email']?>"/>
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
<?php include 'msg_modal.php';?>
<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='static/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type="text/javascript" src="static/js/jquery.form.js"></script>
<script type='text/javascript' src='static/js/jquery.cookie.js'></script>
<script type='text/javascript' src='static/js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript">
    $('#profie_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            var e = '';
            if($('#old_password').val()!='') {            
                if($('#new_password').val()=='') {
                    e+='<li>新密码不能为空</li>';
                }
                if($('#new_password').val().length<6) {
                    e+='<li>新密码不能少于六位</li>';
                }
                if($('#new_password').val()!=$('#re_password').val()) {
                    e+='<li>两次密码必须相等</li>';
                }
            }
            if($('#email').val()=='') {
                e+='<li>邮箱不能为空</li>';
            }
            if(!$('#email').val().match(/[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}[0-9a-z]\.){1,4}[a-z]{2,4}/)) {
                e+='<li>邮箱格式不正确</li>';
            }
            if(e==''){                
                return true;
            }else{
                showMsg('<ol>'+e+'</ol>');
                return false;
            }
        },
        error:function(){
            showMsg('系统错误!');
        },
        success:function(d){
            if(d.state) {
                showSuccess(d.info);
            } else {
                showError(d.info);
            } 
        }
    });
	$("#name").select();
</script>
</body>
</html>