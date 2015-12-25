<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新增商品</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="static/less/styles.less" rel="stylesheet/less" media="all"> 
    <!-- <link rel="stylesheet" href="static/css/styles.css?=121"> -->
    <link href='http://fonts.useso.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>
	<link href='static/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='styleswitcher'> 
	<link href='static/demo/variations/default.css' rel='stylesheet' type='text/css' media='all' id='headerswitcher'> 
    
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="static/css/ie8.css">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
        <script type="text/javascript" src="static/plugins/charts-flot/excanvas.min.js"></script>
	<![endif]-->

	<!-- The following CSS are included as plugins and can be removed if unused-->

	<link rel='stylesheet' type='text/css' href='static/plugins/codeprettifier/prettify.css' /> 
	<link rel='stylesheet' type='text/css' href='static/plugins/form-toggle/toggles.css' /> 

	<script type="text/javascript" src="static/js/less.js"></script>
</head>

<body>
    <?php include 'header.php';?>

    <div id="page-container">
        <?php include 'nav.php';?>

<div id="page-content">
    <div id='wrap'>
        <div id="page-heading">
            <ul class="breadcrumb">
                <li><a href="index.php">商品管理</a></li>
                <li class="active">新增商品</li>
            </ul>

            <h1>新增商品</h1>
            <div class="options">
                <div class="btn-toolbar">
					<a href='?' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 商品信息  </span></a>
                </div>
            </div>
        </div>
<div class="container">

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-sky">
            <div class="panel-heading"><h4>新增商品</h4></div>
            <div class="panel-body">
                <p>Front-end, UX aware form validation without writing a single line of code!</p>
                <form action="" class="form-horizontal row-border"  data-validate="parsley" id="validate-form">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">编号</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Required Field" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">名称</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="At least 6 characters" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">简码</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="At least 6 characters" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">分类</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="(XXX) XXXX XXX" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">规格</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="At most 6 characters" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">条码</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Between 5 and 10 characters" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">单位</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Hexadecimal Color Code" required="required" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">进价</label>
                        <div class="col-sm-6">
                            <input type="text" data-type="email" placeholder="Email address" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">售价</label>
                        <div class="col-sm-6">
                            <input type="text" data-type="url" placeholder="URL address" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>
                        <div class="col-sm-6">
							<label class="radio-inline">
							  <input type="radio" id="inlinecheckbox1" value="option1" data-group="state"> 启用
							</label>
							<label class="radio-inline">
							  <input type="radio" id="inlinecheckbox2" value="option2" data-group="state" required="required"> 禁用
							</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">库存</label>
                        <div class="col-sm-6">
							<label class="radio-inline">
							  <input type="radio" id="inlinecheckbox1" value="option1" data-group="stock" checked="checked"> 计入
							</label>
							<label class="radio-inline">
							  <input type="radio" id="inlinecheckbox2" value="option2" data-group="stock" required="required"> 不计
							</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="btn-toolbar">
                            <button class="btn btn-primary" onclick="javascript:$('#validate-form').parsley( 'validate' );"/>提交</button>
                            <button class="btn-default btn">取消</button>
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

<!--
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

<script>!window.jQuery && document.write(unescape('%3Cscript src="static/js/jquery-1.10.2.min.js"%3E%3C/script%3E'))</script>
<script type="text/javascript">!window.jQuery.ui && document.write(unescape('%3Cscript src="static/js/jqueryui-1.10.3.min.js'))</script>
-->

<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='static/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='static/js/bootstrap.min.js'></script> 
<script type='text/javascript' src='static/js/enquire.js'></script> 
<script type='text/javascript' src='static/js/jquery.cookie.js'></script> 
<script type='text/javascript' src='static/js/jquery.nicescroll.min.js'></script>  
<script type='text/javascript' src='static/plugins/form-toggle/toggle.min.js'></script> 
<script type='text/javascript' src='static/plugins/form-parsley/parsley.min.js'></script> 
<script type='text/javascript' src='static/demo/demo-formvalidation.js'></script> 
<script type='text/javascript' src='static/js/placeholdr.js'></script> 
<script type='text/javascript' src='static/js/application.js'></script> 
<script type='text/javascript' src='static/demo/demo.js'></script> 

</body>
</html>