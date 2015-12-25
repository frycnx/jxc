<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>欠款查询</title>
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
                <li><a href="<?php echo url('Customer')?>">客户管理</a></li>
                <li class="active">欠款查询</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>欠款列表</h4>
                            <div class="options">
								<div class="btn-toolbar">
								<a href="javascript:;" class="btn btn-default"><i class="fa fa-cloud-download"><span class="hidden-sm"> 导出</span></i></a>
								</div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-xs-3 text-left">
							<div class="form-inline form-group">
							<select size="1" class="form-control" id="cate_table_select"><option value="25">25</option><option value="50">50</option><option value="100">100</option></select><label class="control-label">条/页</label>
							</div>
							</div>
                            <div class="col-xs-9 text-right">
							<form class="form-inline" id="cate_table_search">
							<div class="form-group">
							<input type="text" name="kw" class="form-control" placeholder="姓名/电话">
							<input type="submit" class="btn" value="搜索"/>
                            </div>
                            </form>
							</div>							
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="cate_table">
                                <thead>
                                    <tr>
                                    <th>日期</th>
                                    <th>分店</th>
                                    <th>编号</th>
                                    <th>名称</th>
                                    <th>应收</th>
                                    <th>实收</th>
                                    <th>优惠</th>
                                    <th>欠款</th>
                                    <th>操作员</th>
                                    <th>备注</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-xs-4 text-left"><label class="control-label" id="cate_table_info"></label></div>
                            <div class="col-xs-8 text-right" id="table_page"></div>
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
<?php include 'msg_modal.php';?>
<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='static/js/jqueryui-1.10.3.min.js'></script> 
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<script type="text/javascript">
$("#cate_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "table_page",
    "pageInfoContainer": "cate_table_info",
    "pageNumSelect": "cate_table_select",
    "searchForm": "cate_table_search",
	"url": '<?php echo url('Customer')?>',
	"columns": [
			{"name":"id", "data": "id"},
            {"name":"shop", "data": "shop"},
            {"name":"id", "data": "id"},
			{"name":"name", "data": "name"},
            {"name":"overdraft", "data": "overdraft" },
            {"name":"consume", "data": "consume" },
            {"name":"offer", "data": "offer" },
            {"name":"contact", "data": "contact" },
            {"name":"phone", "data": "phone" },
            {"name":"memo", "data": "memo" }
		],
    "complete": function(cb){
        $('.cate_table_delete').click(function(){
        $.ajax({
          type: "GET",
          url: $(this).attr('href'),
          dataType: "json",
          beforeSend: function (){
              showMsg('正在删除...');
          },
          error: function (){
              showMsg('删除失败,请联系管理员');
          },
          success : function (d){
            if(d.state) {
                showSuccess(d.info,function(){cb('reload')});
            } else {
                showError(d.info,function(){cb('reload')});
            }
          }
        });
        return false;
       });
    }
});
</script>
</body>
</html>