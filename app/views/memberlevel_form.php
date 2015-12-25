<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="member_level_form">
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
        <label class="col-sm-3 control-label">级别</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="form_name" class="form-control" value="<?php echo $row['name']?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">折扣</label>
        <div class="col-sm-6">
            <input type="text" name="discount" id="form_discount" class="form-control" value="<?php echo $row['discount']?>" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">状态</label>
        <div class="col-sm-6">
            <label class="radio-inline">
              <input type="radio" name="status" value="1" <?php echo $row['status']=='1'?'checked="checked"':''?> data-group="state"/> 是
            </label>
            <label class="radio-inline">
              <input type="radio" name="status" value="0" <?php echo $row['status']=='0'?'checked="checked"':''?> data-group="state"/> 否
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
        $('#member_level_form').ajaxForm({
            dataType:'json',
            beforeSubmit:function(){
                if($('#form_name').val()=='') {
                    showMsg('级别不能为空！');
                    return false;
                }
                if($('#form_discount').val()=='') {
                    showMsg('折扣不能为空！');
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
                    $("#member_level_form").parent().parent().find(".close").click();
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
                <li><a href="<?php echo url('Member')?>">会员管理</a></li>
                <li><a href="<?php echo url('MemberLevel')?>">会员级别</a></li>
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
						<a href='<?php echo url('MemberLevel')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="hidden-sm"> 会员级别  </span></a>
					</div>
				</div>
			</div>
            <form action="<?php echo $action?>" method="post" class="form-horizontal row-border" id="shop_form">
            <?php if(!empty($row['id'])):?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
			<?php echo inputHash();?>
            <div class="panel-body">                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">级别</label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="form_name" class="form-control" value="<?php echo $row['name']?>" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">折扣</label>
                        <div class="col-sm-6">
                            <input type="text" name="discount" id="form_discount" class="form-control" value="<?php echo $row['discount']?>" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">状态</label>
                        <div class="col-sm-6">
							<label class="radio-inline">
							  <input type="radio" name="status" value="1" <?php echo $row['status']=='1'?'checked="checked"':''?> data-group="state"/> 是
							</label>
							<label class="radio-inline">
							  <input type="radio" name="status" value="0" <?php echo $row['status']=='0'?'checked="checked"':''?> data-group="state"/> 否
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