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
            <div class="panel-heading"><h4><?php echo $title?></h4></div>
            <form action="<?php echo url('Option')?>" method="post" class="form-horizontal row-border" id="option_form">
			<?php echo inputHash();?>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label">商品编号位数，最小长度</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="商品编号位数，最小长度" name="opt[goods_unit]" class="form-control" value="<?php echo $opt['goods_unit']?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">客户编号位数，最小长度</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="客户编号位数，最小长度" name="opt[customer_unit]" class="form-control" value="<?php echo $opt['customer_unit']?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员编号位数，最小长度</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="会员编号位数，最小长度" name="opt[member_unit]" class="form-control" value="<?php echo $opt['member_unit']?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员消费积分/元</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="会员消费积分/元" name="opt[member_point]" class="form-control" value="<?php echo $opt['member_point']?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">零售结帐时金额小数位数</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="零售结帐时金额小数位数" name="opt[sale_round]" class="form-control" value="<?php echo $opt['sale_round']?>" required="required"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">零售结帐时金额进位方式</label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                          <input type="radio" name="opt[sale_type]" value="0"  data-group="state"<?php if($opt['sale_type']=='0'):?> checked="checked"<?php endif?>/> 直接舍去
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="opt[sale_type]" value="1"  data-group="state"<?php if($opt['sale_type']=='1'):?> checked="checked"<?php endif?>/> 四舍五入
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">允许销售负库存商品</label>
                    <div class="col-sm-6">
                        <label class="radio-inline">
                          <input type="radio" name="opt[minus_stock]" value="1"  data-group="state"<?php if($opt['minus_stock']=='1'):?> checked="checked"<?php endif?>/> 启用
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="opt[minus_stock]" value="0" data-group="state"<?php if($opt['minus_stock']=='0'):?> checked="checked"<?php endif?>/> 禁用
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
<script type="text/javascript" src="static/js/jquery.form.js"></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<script type="text/javascript">
    $('#option_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('input[name="opt[goods_unit]"]').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
                return false;
            }
            if($('input[name="opt[customer_unit]"]').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
                return false;
            }
            if($('input[name="opt[member_unit]"]').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
                return false;
            }
            if($('input[name="opt[member_point]"]').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
                return false;
            }
            if($('input[name="opt[sale_round]"]').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
                return false;
            }
            if($('input[name="opt[sale_type]"]:checked').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
                return false;
            }
            if($('input[name="opt[minus_stock]"]:checked').val()=='') {
                showError('"<?php echo $row['lang']?>"不能为空！');
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
            } else {
                showError(d.info);
            }
        }
    });
</script>
</body>
</html>