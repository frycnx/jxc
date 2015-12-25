<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>统计管理</title>
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
                <li>统计管理</li>
                <li class="active">综合统计</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>综合统计</h4>
                            <div class="options">
                                <div class="btn-toolbar">
                                    <a href='<?php echo url('User','add')?>' class="btn btn-default"><i class="fa fa-cloud-download"></i><span class="hidden-sm"> 导出  </span></a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            <div class="col-xs-12 text-right">
							<form class="form-inline" id="_table_search">
							<div class="form-group">
                            <button class="btn btn-default" id="daterangepicker">
                                <i class="fa fa-calendar-o"></i> 
                                <span class="hidden-xs hidden-sm"></span> <b class="caret"></b>
                            </button>
                            <input type="hidden" name="start_time" id="start_time"/>
                            <input type="hidden" name="end_time" id="end_time"/>
                            <select size="1" class="form-control" name="shop_id">
                            <option value="">---</option>
                            <?php foreach($my_shop as $key=>$val):?>
                            <option value="<?php echo $key?>"><?php echo $val?></option>
                            <?php endforeach?>
                            </select>
							<input type="submit" class="btn" value="搜索"/>
                            </div>
                            </form>
							</div>							
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="_table">
                                <tbody>
                                <tr>
                                    <td colspan="8">入库统计</td>
                                </tr>
                                <tr>
                                    <td>进货数量</td>
                                    <td>0.00</td>
                                    <td>报溢数量</td>
                                    <td>0.00</td>
                                    <td>还货数量</td>
                                    <td>0.00</td>
                                    <td>其它入库</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>进货金额</td>
                                    <td>0.00</td>
                                    <td>报溢金额</td>
                                    <td>0.00</td>
                                    <td>还货金额</td>
                                    <td>0.00</td>
                                    <td>其它金额</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>合计数量</td>
                                    <td>0.00</td>
                                    <td>合计金额</td>
                                    <td>0.00</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="8">出库统计</td>
                                </tr>
                                <tr>
                                    <td>退货数量</td>
                                    <td>0.00</td>
                                    <td>报损数量</td>
                                    <td>0.00</td>
                                    <td>借货数量</td>
                                    <td>0.00</td>
                                    <td>其它出库</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>退货金额</td>
                                    <td>0.00</td>
                                    <td>报损金额</td>
                                    <td>0.00</td>
                                    <td>借货金额</td>
                                    <td>0.00</td>
                                    <td>其它金额</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>合计数量</td>
                                    <td>0.00</td>
                                    <td>合计金额</td>
                                    <td>0.00</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="8">销售统计</td>
                                </tr>
                                <tr>
                                    <td>销售数量</td>
                                    <td>0.00</td>
                                    <td>退货数量</td>
                                    <td>0.00</td>
                                    <td>销售成本</td>
                                    <td>0.00</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>销售金额</td>
                                    <td>0.00</td>
                                    <td>退货金额</td>
                                    <td>0.00</td>
                                    <td>销售利润</td>
                                    <td>0.00</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="8">财务统计</td>
                                </tr>
                                <tr>
                                    <td>应收合计</td>
                                    <td>0.00</td>
                                    <td>优惠合计</td>
                                    <td>0.00</td>
                                    <td>客户付款</td>
                                    <td>0.00</td>
                                    <td>会员交费</td>
                                    <td>0.00</td>
                                </tr>
                                <tr>
                                    <td>实收合计</td>
                                    <td>0.00</td>
                                    <td>欠款合计</td>
                                    <td>0.00</td>
                                    <td>实收现金</td>
                                    <td>0.00</td>
                                    <td>储值卡消费</td>
                                    <td>0.00</td>
                                </tr>
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
<?php include 'msg_modal.php';?>
<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script>
<link href="static/js/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" media="all">
<script type='text/javascript' src='static/js/daterangepicker/daterangepicker.min.js'></script> 
<script type='text/javascript' src='static/js/moment/moment.min.js'></script>
<script type='text/javascript' src='static/js/moment/lang/zh-cn.js'></script>
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/jquery.cookie.js'></script>
<script type='text/javascript' src='static/js/jquery.nicescroll.min.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<?php include 'ajax_load.php';?>
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
          format: 'YYYY-DD-MM',
          opens: 'left',
          startDate: moment().subtract('days', 29),
        },
        function(start, end) {
            var s,e;
            if(start>end) {
                s='';
                e='';
            } else {
                s=start.format('YYYY-DD-MM');
                e=end.format('YYYY-DD-MM');
            }
            $('#start_time').val(s);
            $('#end_time').val(e);
            $('#daterangepicker span').html(s + ' - ' + e);
        }
    );
/*
$("#_table").ajaxTable({
	"loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "_table_page",
    "pageInfoContainer": "_table_info",
    "pageNumSelect": "_table_num",
    "searchForm": "_table_search",
	"url": '<?php echo url('Stock')?>',
	"columns": [
			{"name":"goods_id", "data": "goods_id"},
			{"name":"goods_name", "data": "goods_name"},
            {"name":"spec", "data": "spec"},
            {"name":"unit", "data": "unit"},
            {"name":"barcode", "data": "barcode"},
            {"name":"cate_name", "data": "cate_name"},
            {"name":"shop_name", "data": "shop_name"},
            {"name":"amount", "data": "amount"},
            {"name":"price_cost", "data": "price_cost"},
            {"name":"price_cost", "data": "price_cost"},
            {"name":"price_sell", "data": "price_sell"},
            {"name":"price_sell", "data": "price_sell"}
		],
    "complete": function(cb){
    }
});
*/
</script>
</body>
</html>