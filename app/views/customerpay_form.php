<?php if(isAjax()):?>
<form action="<?php echo $action?>" method="post" class="form-horizontal" id="pay_form">
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
        <label class="col-sm-3 control-label">分店</label>
        <div class="col-sm-6">
            <input type="text" name="shop_name" id="form_shop_name" class="form-control" value="<?php echo $row['shop_name']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">客户</label>
        <div class="col-sm-6">
            <input type="text" name="customer_name" id="form_customer_name" class="form-control" value="<?php echo $row['name']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">联系人</label>
        <div class="col-sm-6">
            <input type="text" name="customer_contact" id="form_customer_contact" class="form-control" value="<?php echo $row['contact']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">电话</label>
        <div class="col-sm-6">
            <input type="text" name="customer_phone" id="form_customer_phone" class="form-control" value="<?php echo $row['phone']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">消费</label>
        <div class="col-sm-6">
            <input type="text" name="customer_consume" id="form_customer_consume" class="form-control" value="<?php echo $row['consume']?>"  readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">优惠</label>
        <div class="col-sm-6">
            <input type="text" name="customer_offer" id="form_customer_offer" class="form-control" value="<?php echo $row['offer']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">欠款</label>
        <div class="col-sm-6">
            <input type="text" name="customer_overdraft" id="form_customer_overdraft" class="form-control" value="<?php echo $row['overdraft']?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">收款金额</label>
        <div class="col-sm-6">
            <input type="text" placeholder="收款后欠款的记录将补平" name="pay" id="form_pay" class="form-control" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">收款优惠</label>
        <div class="col-sm-6">
            <input type="text" name="offer" id="form_offer" class="form-control" value="0.00" required="required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">收款备注</label>
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
    $('#pay_form').ajaxForm({
        dataType:'json',
        beforeSubmit:function(){
            if($('#form_pay').val()=='') {
                showMsg('收款金额不能为空！');
                return false;
            }
            if($('#form_offer').val()=='') {
                showMsg('收款优惠不能为空！');
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
                $("#pay_form").parent().parent().find(".close").click();
                $("#_table").trigger('ajaxLoad');
            } else {
                showError(d.info);
            } 
        }
    });
	$("#form_pay").select();
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
                <li>客户管理</li>
                <li><a href="<?php echo url('CustomerPay')?>">客户收款</a></li>
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
                        <a href='<?php echo url('CustomerPay')?>' class="btn btn-default"><i class="fa fa-list"></i><span class="CustomerPay"> 收款查询  </span></a>
                    </div>
                </div>
            </div>
            <form action="<?php echo $action?>" method="post" class="form-horizontal row-border" id="pay_form">
            <?php if(!empty($row['id'])):?>
            <input type="hidden" name="id" value="<?php echo $row['id']?>"/>
            <?php endif;?>
            <?php echo inputHash();?>
            <div class="panel-body">                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">分店</label>
                        <div class="col-sm-6">
                            <input type="text" name="shop_name" id="form_shop_name" class="form-control" value="<?php echo $row['shop_name']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">客户</label>
                        <div class="col-sm-6">
                            <input type="text" name="customer_name" id="form_customer_name" class="form-control" value="<?php echo $row['name']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">联系人</label>
                        <div class="col-sm-6">
                            <input type="text" name="customer_contact" id="form_customer_contact" class="form-control" value="<?php echo $row['contact']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">电话</label>
                        <div class="col-sm-6">
                            <input type="text" name="customer_phone" id="form_customer_phone" class="form-control" value="<?php echo $row['phone']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">消费</label>
                        <div class="col-sm-6">
                            <input type="text" name="customer_consume" id="form_customer_consume" class="form-control" value="<?php echo $row['consume']?>"  readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">优惠</label>
                        <div class="col-sm-6">
                            <input type="text" name="customer_offer" id="form_customer_offer" class="form-control" value="<?php echo $row['offer']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">欠款</label>
                        <div class="col-sm-6">
                            <input type="text" name="customer_overdraft" id="form_customer_overdraft" class="form-control" value="<?php echo $row['overdraft']?>" readonly="readonly"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">收款金额</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="收款后欠款的记录将补平" name="pay" id="form_pay" class="form-control" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">收款优惠</label>
                        <div class="col-sm-6">
                            <input type="text" name="offer" id="form_offer" class="form-control" value="0.00" required="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">收款备注</label>
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
<script type="text/javascript">$("#form_pay").select();</script>
</body>
</html>
<?php endif;?>