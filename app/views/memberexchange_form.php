<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="exchange_form">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><?php echo $title?></h4>
</div>
<div class="modal-body">
    <?php if(!empty($row['id'])):?>
    <input type="hidden" name="id" value="<?php echo $row['id']?>" required="required"/>
    <?php endif;?>
    <?php echo inputHash();?>
    <div class="form-group">
        <label class="col-sm-3 control-label">店铺</label>
        <div class="col-sm-6">
            <input type="text" name="shop_name" id="form_shop_name" class="form-control" value="<?php echo $row['shop_name']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">会员卡号</label>
        <div class="col-sm-6">
            <input type="text" name="card" id="form_card" class="form-control" value="<?php echo $row['card']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">会员姓名</label>
        <div class="col-sm-6">
            <input type="text" name="name" id="form_name" class="form-control"  value="<?php echo $row['name']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">会员级别</label>
        <div class="col-sm-6">
            <input type="text" name="level_name" id="form_level_name" class="form-control" value="<?php echo $row['level_name']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">会员折扣</label>
        <div class="col-sm-6">
            <input type="text" name="level_discount" id="form_level_discount" class="form-control" value="<?php echo $row['level_discount']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">累计消费</label>
        <div class="col-sm-6">
            <input type="text" name="consume" id="form_consume" class="form-control" value="<?php echo $row['consume']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">所有积分</label>
        <div class="col-sm-6">
            <input type="text" name="all_point" id="form_all_point" class="form-control" value="<?php echo $row['point']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">兑换积分</label>
        <div class="col-sm-6">
            <input type="text" name="point" id="form_point" required="required" class="form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">剩余积分</label>
        <div class="col-sm-6">
            <input type="text" name="current_point" id="form_current_point" class="form-control" value="<?php echo $row['point']?>" readonly="readonly"/>
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
    $('#exchange_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('#form_point').val()=='') {
                showMsg('兑换积分不能为空！');
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
                $("#exchange_form").parent().parent().find(".close").click();
                $("#_table").trigger('ajaxLoad');
            } else {
                showError(d.info);
            } 
        }
    });
    $('#form_point').keyup(function(){
        var p=parseFloat($('#form_all_point').val())-parseFloat($(this).val());
        $('#form_current_point').val(isNaN(p)?'0':p);
        if(p < 0) { 
            $(this).val($('#form_all_point').val()); 
            $('#form_current_point').val('0');
        }
    }).focus();
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
                <li><a href="<?php echo url('Member')?>">兑换查询</a></li>
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
            <form action="<?php echo $action?>" method="post" class="form-horizontal row-border" id="exchange_form">
                <?php if(!empty($row['id'])):?>
                <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
                <?php endif;?>
                <?php echo inputHash();?>            
                <div class="panel-body">  
                <div class="form-group">
                    <label class="col-sm-3 control-label">店铺</label>
                    <div class="col-sm-6">
                        <input type="text" name="shop_name" id="form_shop_name" class="form-control" required="required" value="<?php echo $row['shop_name']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员卡号</label>
                    <div class="col-sm-6">
                        <input type="text" name="card" id="form_card" class="form-control" required="required" value="<?php echo $row['card']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员姓名</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="form_name" class="form-control"  value="<?php echo $row['name']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员级别</label>
                    <div class="col-sm-6">
                        <input type="text" name="level_name" id="form_level_name" class="form-control" value="<?php echo $row['level_name']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">会员折扣</label>
                    <div class="col-sm-6">
                        <input type="text" name="level_discount" id="form_level_discount" class="form-control" value="<?php echo $row['level_discount']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">累计消费</label>
                    <div class="col-sm-6">
                        <input type="text" name="consume" id="form_consume" class="form-control" value="<?php echo $row['consume']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">所有积分</label>
                    <div class="col-sm-6">
                        <input type="text" name="all_point" id="form_all_point" class="form-control" value="<?php echo $row['point']?>" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">兑换积分</label>
                    <div class="col-sm-6">
                        <input type="text" name="point" id="form_point" required="required" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">剩余积分</label>
                    <div class="col-sm-6">
                        <input type="text" name="current_point" id="form_current_point" class="form-control" value="<?php echo $row['point']?>" readonly="readonly"/>
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
<script type="text/javascript">
    $('#form_point').keyup(function(){
        var p=parseFloat($('#form_all_point').val())-parseFloat($(this).val());
        $('#form_current_point').val(isNaN(p)?'0':p);
        if(p < 0) { 
            $(this).val($('#form_all_point').val()); 
            $('#form_current_point').val('0');
        }
    }).focus();
</script>
</body>
</html>
<?php endif;?>