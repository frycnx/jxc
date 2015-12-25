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
                <li><a href="<?php echo url('Customer')?>">客户管理</a></li>
                <li><a href="<?php echo url('Customer')?>">客户信息</a></li>
                <li class="active"><?php echo $title?></li>
            </ul>

            <h1><?php echo $title?></h1>
            <div class="options">
                <div class="btn-toolbar">
					<a href='<?php echo url('Customer')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 客户信息  </span></a>
                </div>
            </div>
        </div>
<div class="container">

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-sky">
            <div class="panel-heading"><h4><?php echo $title?></h4></div>
            <form action="<?php echo url('Customer','doSave')?>" method="post" class="form-horizontal row-border" id="category_form">
            <?php echo inputHash();?>
            <input type="hidden" name="from_act" value="<?php echo $row['from_act']?>"/>
            <div class="panel-body">                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">分店</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="分店" name="shop" id="shop" readonly="readonly" class="form-control" value="<?php echo $row['shop']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">客户</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="客户" name="name" id="name" required="required" class="form-control" value="<?php echo $row['name']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">联系人</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="联系人" name="contact" id="contact" required="required" class="form-control" value="<?php echo $row['contact']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">电话</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="电话" name="phone" id="phone" required="required" class="form-control" value="<?php echo $row['phone']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">地址</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="地址" name="address" id="address" required="required" class="form-control" value="<?php echo $row['address']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">消费</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="消费" name="consume" id="consume" class="form-control" value="<?php echo $row['consume']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">优惠</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="优惠" name="offer" id="offer" class="form-control" value="<?php echo $row['offer']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">欠款</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="欠款" name="overdraft" id="overdraft" class="form-control" value="<?php echo $row['overdraft']?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">备注</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="备注" name="memo" id="memo" class="form-control" value="<?php echo $row['memo']?>"/>
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
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript">
    $('#category_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('#category_name').val()=='') {
                showMsg('分类不能为空！');
                return false;
            }else{
                return true;
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
</script>
</body>
</html>