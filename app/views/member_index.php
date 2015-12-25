<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>会员信息</title>
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
            <ol class="breadcrumb">
                <li><a href="<?php echo url('Member')?>">会员管理</a></li>
                <li class="active">会员信息</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>会员列表</h4>
							<div class="options">
								<div class="btn-toolbar">
									<a href="<?php echo url('Member','add')?>" class="btn btn-default addMember"><i class="fa fa-plus"></i><span class="hidden-sm"> 新增会员  </span></a>
									<a href="<?php echo url('Member','import')?>" class="btn btn-default importMember"><i class="fa fa-cloud-download"><span class="hidden-sm"> 导出</span></i></a>
								</div>
							</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-xs-3 text-left">
							<div class="form-inline form-group">
							<select size="1" class="form-control" id="_table_num"><option value="25">25</option><option value="50">50</option><option value="100">100</option></select><label class="control-label">条/页</label>
							</div>
							</div>
                            <div class="col-xs-9 text-right">
							<form class="form-inline" id="_table_search">
							<div class="form-group">
                            <select size="1" class="form-control" name="shop_id">
                            <option value="">---</option>
                            <?php foreach($my_shop as $key=>$val):?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
                            <select size="1" class="form-control" name="level_id">
                            <option value="">---</option>
                            <?php foreach($member_level as $key=>$val):?>
                            <option value="<?php echo $key?>" discount="<?php echo $val['discount']?>"><?php echo $val['name']?></option>
                            <?php endforeach?>
                            </select>
							<input type="text" name="kw" class="form-control" placeholder="姓名/电话">
							<input type="submit" class="btn" value="搜索"/>
                            </div>
                            </form>
							</div>							
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="_table">
                                <thead>
                                    <tr>
                                    <th>卡号</th>
                                    <th>店铺</th>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>生日</th>
                                    <th>电话</th>
                                    <th>地址</th>
                                    <th>级别</th>
                                    <th>折扣</th>
                                    <th>预存</th>
                                    <th>消费</th>
                                    <th>积分</th>
                                    <th>加入</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-4 text-left"><label class="control-label" id="_table_info"></label></div>
                            <div class="col-xs-8 text-right" id="_table_page"></div>
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
<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/placeholdr.js'></script>
<script type="text/javascript" src="static/js/jquery.form.js"></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<?php include 'ajax_load.php';?>
<script type="text/javascript">
$("#_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "_table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('Member')?>',
	"columns": [
			{"name":"card", "data": "card"},
            {"name":"shop_name", "data": "shop_name"},
			{"name":"name", "data": "name"},
			{"name":"sex", "data": function(d){if(d['sex']=='m'){return '男';}else if(d['sex']=='f'){return '女';}else{return '密';}} },
            {"name":"birth", "data": "birth" },
            {"name":"phone", "data": "phone" },
            {"name":"address", "data": "address" },
            {"name":"level_name", "data": "level_name" },
            {"name":"level_discount", "data": "level_discount" },
            {"name":"money", "data": "money" },
            {"name":"consume", "data": "consume" },
            {"name":"point", "data": "point" },
            {"name":"create_time", "data": function(d){return date('Y-m-d',d['create_time']);} },
            {"name":"memo", "data": "memo" },
            { "data": function(d){return '<div class="btn-group"><a class="editMember" href="<?php echo url('Member','edit')?>&id='+d["id"]+'" title="编辑"><i class="fa fa-edit"></i><span class="hidden-sm">编辑</span></a></div>&nbsp;<div class="btn-group"><a class="delMember" href="<?php echo url('Member','del')?>&id='+d["id"]+'" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div>';}, "sortable": false}
		],
    "complete": function(cb){
        $(".editMember").click(function(){
            ajaxLoad(this.href);
            return false;
        });
        $(".delMember").click(function(){
            $.ajax({
              type: "GET",
              url: this.href,
              dataType: "json",
              beforeSend: function (){
                  showMsg('正在删除...');
              },
              error: function (){
                  showMsg('删除失败,请联系管理员');
              },
              success : function (d){
                if(d.state) {
                    showSuccess(d.info,function(){$("#_table").trigger('ajaxLoad');});
                } else {
                    showError(d.info,function(){$("#_table").trigger('ajaxLoad');});
                }
              }
            });
            return false;
        });
        $("#_table tbody tr").dblclick(function(){
			$(this).find(".editMember").click();
        });
    }
});
$(".addMember").click(function(){
    ajaxLoad(this.href);
    return false;
});
$(".importMember").click(function(){
    var url = this.href;
    $("#_table").trigger('getParams',function(d){
		window.open(url + (url.indexOf('?')>=0?'&':'?') + d);
    });
    return false;
});
</script>
</body>
</html>