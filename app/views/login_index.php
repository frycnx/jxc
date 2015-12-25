<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="static/css/style.css" rel="stylesheet" media="all">
	<link href="static/css/font-awesome.css" rel="stylesheet" media="all">
</head>
<body class="focusedform">
<div class="verticalcenter">
	<a href="index.php" style="display:none"><img src="static/img/logo-big.png" alt="Logo" class="brand" /></a>
	<div class="panel panel-primary">
		<div class="panel-body">
			<h4 class="text-center" style="margin-bottom: 25px;">登录</h4>
				<form action="<?php echo url('Login','doLogin')?>" method="post" class="form-horizontal" id="login">
					<div class="form-group">
						<label for="username" class="control-label col-sm-4" style="text-align: left;">用户名</label>
						<div class="col-sm-8">
							<input type="text" name="username" class="form-control" id="username" placeholder="用户名">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="control-label col-sm-4" style="text-align: left;">密码</label>
						<div class="col-sm-8">
							<input type="password" name="password" class="form-control" id="password" placeholder="密码">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="control-label col-sm-4" style="text-align: left;">验证码</label>
						<div class="col-sm-8">
                            <div class="input-group">
                              <input type="text" name="verify" class="form-control" id="verify"  placeholder="验证码"/>
                              <div class="input-group-btn">
                                <img src="<?php echo url('Login','security')?>" onclick="this.src='<?php echo url('Login','security')?>&_='+(new Date()).getTime()" style="cursor:pointer"/>
                              </div>
                            </div>
						</div>
					</div>
                    <!--
					<div class="clearfix">
						<div class="pull-right"><label><input type="checkbox" checked> 记住我</label></div>
					</div>
                    -->
                    <input type="hidden" name="hash" value="<?php echo $hash?>">
                    <input type="submit" class="btn btn-primary btn-block" value="登录"/>
				</form>
		</div>
		<div class="panel-footer" style="display:none">
			<a href="extras-forgotpassword.php" class="pull-left btn btn-link" style="padding-left:0">忘记密码?</a>
			
			<div class="pull-right">
				<a href="#" class="btn btn-default">注册</a>
			</div>
		</div>
	</div>
 </div>

<script type="text/javascript" src="static/js/jquery-1.10.2.min.js"></script>
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type="text/javascript" src="static/js/jquery.form.js"></script>
<script type="text/javascript">
	$("#login").ajaxForm({
		dataType:'json',
		beforeSubmit:function(){
			if($('#username').val()==''){
				show_msg('账号不能为空!',0);
				return false;
			}
			if($('#password').val()==''){
				show_msg('密码不能为空!',0);
				return false;
			}
			return true;
		},
		error:function(){show_msg('系统错误!',0);},
		success:function(d){
			if(!d||isNaN(d.state))show_msg('系统错误!',0);
			show_msg(d.info,d.state);
			if(d.state&&d.url){
				window.location.href=d.url;
			}
		}
	});
    $("#username").focus();
	function show_msg(message,state){
		$("#login").prev('.alert').remove();
		var msg = '';
		msg += '<div class="alert alert-dismissable ';
		msg += state?'alert-success">':'alert-danger">';
		msg += message;
		msg += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
		msg += '</div>';
		$("#login").before(msg);
	}
</script>  
</body>
</html>