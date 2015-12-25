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
                <li class="active">消费查询</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>消费查询</h4>
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
                            <button class="btn btn-default" id="daterangepicker">
                                <i class="fa fa-calendar-o"></i> 
                                <span class="hidden-xs hidden-sm"></span> <b class="caret"></b>
                            </button>
                            <input type="hidden" name="start_time" id="start_time"/>
                            <input type="hidden" name="end_time" id="end_time"/>
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
                                    <th>姓名</th>
                                    <th>商品</th>
                                    <th>单位</th>
                                    <th>规格</th>
                                    <th>单价</th>
                                    <th>折扣</th>
                                    <th>数量</th>
                                    <th>金额</th>
                                    <th>操作员</th>
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
<script type='text/javascript' src='static/js/jquery.cookie.js'></script>
<script type='text/javascript' src='static/js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<link href="static/js/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" media="all">
<script type='text/javascript' src='static/js/daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='static/js/moment/moment.min.js'></script>
<script type='text/javascript' src='static/js/moment/lang/zh-cn.js'></script>
<script type="text/javascript">
$("#daterangepicker").daterangepicker(
        {
          ranges: {
             '所有': [moment(), moment().subtract('days', 1)],
             '今天': [moment(), moment()],
             '昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
             '前天': [moment().subtract('days', 2), moment().subtract('days', 2)],
             '7天': [moment().subtract('days', 6), moment()],
             '30天': [moment().subtract('days', 29), moment()],
             '本月': [moment().startOf('month'), moment().endOf('month')],
             '上月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
          },
          locale: {
                 applyLabel:"确定",
                 cancelLabel:"取消",
                 fromLabel:"从",
                 toLabel:"至",
                 weekLabel:"周",
                 customRangeLabel:"自定义"
          },
          format: 'YYYY-MM-DD',
          opens: 'left',
          startDate: moment().subtract('days', 29),
        },
        function(start, end) {
            var s,e;
            if(start>end) {
                s='';
                e='';
            } else {
                s=start.format('YYYY-MM-DD');
                e=end.format('YYYY-MM-DD');
            }
            $('#start_time').val(s);
            $('#end_time').val(e);
            $('#daterangepicker span').html(s + ' - ' + e);
        }
    );
$("#cate_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "table_page",
    "pageInfoContainer": "cate_table_info",
    "pageNumSelect": "cate_table_select",
    "searchForm": "cate_table_search",
	"url": '<?php echo url('MemberConsume')?>',
	"columns": [
            {"name":"create_time", "data": function(d){return date('Y-m-d',d['create_time']);} },
            {"name":"member_name", "data": "member_name"},
			{"name":"shop", "data": "shop"},
            {"name":"goods_name", "data": "goods_name"},
			{"name":"goods_unit", "data": "goods_unit"},
          {"name":"goods_spec", "data": "goods_spec" },
          {"name":"price_sell", "data": "price_sell" },
          {"name":"discount", "data": "discount" },
          {"name":"amount", "data": "amount" },
          {"name":"sum", "data": "sum" },
          {"name":"user_name", "data": "user_name" }
		],
    "complete": function(cb){
    }
});
</script>
</body>
</html>