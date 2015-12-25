<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>会员级别</title>
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
                <li class="active">会员级别</li>
            </ol>
        </div>


        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-heading">
                            <h4>级别列表</h4>
							<div class="options">
								<div class="btn-toolbar">
									<a href='<?php echo url('MemberLevel','add')?>' class="btn btn-default addMemberLevel"><i class="fa fa-plus"></i><span class="hidden-sm"> 新增级别  </span></a>
									<a href="<?php echo url('MemberLevel','import')?>" class="btn btn-default importMemberLevel"><i class="fa fa-cloud-download"><span class="hidden-sm"> 导出</span></i></a>
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
							<input type="text" name="kw" class="form-control" placeholder="级别名...">
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
                                  <th>编号</th>
                                  <th>级别</th>
								  <th>折扣</th>
								  <th>状态</th>
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
	"url": '<?php echo url('MemberLevel')?>',
	"columns": [
			{"name":"id", "data": "id"},
			{"name":"name", "data": "name"},
			{"name":"discount", "data": "discount"},
			{"name":"status", "data": function(d){return '<i class="fa '+(d["status"]=='1'?'fa-check-circle':'fa-times-circle')+'"></i>';} },
			{ "data": function(d){return '<div class="btn-group"><a class="editMemberLevel" href="<?php echo url('MemberLevel','edit')?>&id='+d["id"]+'" title="编辑"><i class="fa fa-edit"></i><span class="hidden-sm">编辑</span></a></div>&nbsp;<div class="btn-group"><a class="delMemberLevel" href="<?php echo url('MemberLevel','del')?>&id='+d["id"]+'" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div>';}, "sortable": false}				
		],
    "complete": function(cb){
        $(".editMemberLevel").click(function(){
            ajaxLoad(this.href);
            return false;
        });
        $(".delMemberLevel").click(function(){
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
			$(this).find(".editMemberLevel").click();
        });
    }
});
$(".addMemberLevel").click(function(){
    ajaxLoad(this.href);
    return false;
});
$(".importMemberLevel").click(function(){
    var url = this.href;
    $("#_table").trigger('getParams',function(d){
		window.open(url + (url.indexOf('?')>=0?'&':'?') + d);
    });
    return false;
});
</script>
</body>
</html>