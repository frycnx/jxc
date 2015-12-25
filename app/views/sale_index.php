<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>零售销售</title>
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
        <div class="container">
            <div class="row">
              <div class="col-md-12">
                    <div class="panel panel-sky">
                        <div class="panel-body">
                            <div class="row form-group">
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">流水</span>
                                  <input type="text" class="form-control" name="sn" id="sn" readonly="readonly"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">店铺</span>
                                  <input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo session('shop_name')?>" readonly="readonly"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">会员卡</span>
                                  <input type="hidden" name="member_id" id="member_id">
                                  <input type="hidden" name="member_money" id="member_money">  
                                  <input type="text" class="form-control" name="member_card" id="member_card" />
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-info">F4</button>
                                  </div>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">姓名</span>
                                  <input type="text" class="form-control" name="member_name" id="member_name" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">级别</span>
                                  <input type="text" class="form-control" name="member_level" id="member_level" readonly="readonly"/>
                                </div>
							</div>
                            <div class="col-xs-2 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">积分</span>
                                  <input type="text" class="form-control" name="member_point" id="member_point" readonly="readonly"/>
                                </div>
							</div>
                            </div>
                            <div class="row">
                            <div class="col-xs-12">
                            <div id="table_list">
                            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover datatables" id="_table">
                                <thead>
                                    <tr>   
                                    <th>序号</th>
                                    <th>编号</th>
                                    <th>名称</th>
                                    <th>规格</th>
                                    <th>单位</th>
                                    <th>折扣</th>
                                    <th>价格</th>
                                    <th>数量</th>
                                    <th>总额</th>
                                    <th>库存</th>
                                    <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th colspan="7" class="text-left">合计</th>
                                    <th>0</th>
                                    <th>0.00</th>
                                    <th></th>
                                    <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
							</div>
                            </div>

                            <div class="row form-group">
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">商品</span>
                                  <input type="text" class="form-control" name="goods" id="goods" />
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-info">&crarr;</button>
                                  </div>
                                </div>
							</div>
                            <div class="col-xs-3 text-left">
                                <div class="input-group">
                                  <span class="input-group-addon">员工</span>
                                  <input type="hidden" name="staff_id" id="staff_id">
                                  <input type="text" class="form-control" name="staff_name" id="staff_name"/>
                                  <div class="input-group-btn">
                                    <button type="button" class="btn btn-info">F7</button>
                                  </div>
                                </div>
                            </div>
                            <div class="col-xs-6 text-left">
                                <div class="btn-toolbar">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="getNoCheck()">挂账(F2)</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" onclick="showCheck()">结账(Ctrl+&crarr;)</button>
                                </div>
                                </div>
							</div>
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

<!-- Modal -->
<div class="modal fade" id="sale_modal" tabindex="-1" role="dialog" aria-labelledby="sale_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" name="footer-cancel">取消(Esc)</button>
                <button type="button" class="btn btn-primary" name="footer-ok">确定(&crarr;)</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/html" id="modal-check">
<div class="table-content">
    <form action="" class="form-horizontal">
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
        <span class="input-group-addon">&nbsp;&nbsp;收款方式&nbsp;&nbsp;</span>
        <div class="form-control">
        <label><input type="radio" name="skfs" value="0" checked="checked"> 现金(Ctrl+m)</label>
        <label><input type="radio" name="skfs" value="1"> 银行卡(Ctrl+b)</label>
        <label><input type="radio" name="skfs" value="2"> 储值卡(Ctrl+c)</label>
        </div>
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">&nbsp;&nbsp;应收金额&nbsp;&nbsp;</span>
    <input type="text" class="form-control" name="ysje" id="ysje" value="<%=ysje%>" readonly="readonly">
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">&nbsp;&nbsp;会员预存&nbsp;&nbsp;</span>
    <input type="text" class="form-control" name="hyyc" id="hyyc" value="<%=hyyc%>">
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">&nbsp;&nbsp;实收金额&nbsp;&nbsp;</span>
    <input type="text" class="form-control" name="ssje" id="ssje">
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">&nbsp;&nbsp;优惠金额&nbsp;&nbsp;</span>
    <input type="text" class="form-control" name="yhje" id="yhje" value="<%=yhje%>" readonly="readonly">
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">&nbsp;&nbsp;找零金额&nbsp;&nbsp;</span>
    <input type="text" class="form-control" name="zlje" id="zlje" value="0.00" readonly="readonly">
    </div>
    </div>
    </div>
    </form>
</div>
</script>
<script type="text/html" id="modal-edit-goods">
<div class="table-content">
    <form action="" class="form-horizontal">
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">编号</span>
    <input type="hidden" name="edit_row_id" id="edit_row_id" value="<%=row_id%>">
    <input type="text" class="form-control" name="edit_goods_sku" id="edit_goods_sku" value="<%=goods_sku%>" readonly="readonly"/>
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">名称</span>
    <input type="text" class="form-control" name="edit_goods_name" id="edit_goods_name" value="<%=goods_name%>" readonly="readonly"/>
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">库存</span>
    <input type="text" class="form-control" name="edit_stock_num" id="edit_stock_num" value="<%=stock_num%>" readonly="readonly"/>
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">数量</span>    
    <input type="text" class="form-control" name="edit_amount" id="edit_amount" value="<%=amount%>">
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">折扣</span>
    <input type="text" class="form-control" name="edit_discount" id="edit_discount"  value="<%=discount%>" readonly="readonly"/>
    </div>
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-12">
    <div class="input-group">
    <span class="input-group-addon">价格</span>
    <input type="text" class="form-control" name="edit_price" id="edit_price"  value="<%=price%>" readonly="readonly"/>
    </div>
    </div>
    </div>
    </form>
</div>
</script>
<script type="text/html" id="modal-common">
<div class="table-content" style="overflow-y:auto;height:<%=$(document).height()*0.6%>px">
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed">
<thead><tr>
<%for(i=0;i<columns.length;i++){%>
<th<%if(!columns[i][2]){%> class="hide"<%}%>><%=columns[i][0]%></th>
<%}%>
</tr></thead>
<tbody>
<%for(i=0;i<data.length;i++) {%>
<tr<%if(i==0){%> class="active"<%}%>>
<%for(j=0;j<columns.length;j++){%>
<td<%if(!columns[j][2]){%> class="hide"<%}%>>
<%if(typeof columns[j][1]==='function'){%>
<%=columns[j][1].call(this,data[i])%>
<%}else{%>
<%=data[i][columns[j][1]]%>
<%}%>
</td>
<%}%>
</tr>
<%}%>
</tbody>
</table>
</div>
</script>
<script type="text/html" id="modal-alert">
<div class="modal-body"><%=body%></div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" name="footer-cancel">取消(Esc)</button>
    <button type="button" class="btn btn-primary" name="footer-ok">确定(&crarr;)</button>
</div>
</script>
<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script>
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/jquery.cookie.js'></script>
<script type='text/javascript' src='static/js/jquery.hotkeys.js'></script>
<script type='text/javascript' src='static/js/ajaxtable.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
<?php include 'msg_modal.php';?>
<script type="text/javascript">
$(function(){
    if (!$("body").hasClass("collapse-leftbar")) {
        $("body").addClass("collapse-leftbar");
        $('.acc-menu').css('display', '');
    }
    window.onbeforeunload = function(){
        if($("#_table tbody tr").length||$("#member_id").val()) {
            return "离开本页则未完成的单据会自动挂账！";
        }
    };
    $("#goods").bind("keydown","return",function(){
        showGoods($(this).val());
        $(this).val("");
    }).focus();
    $("#member_card").bind("keydown","return",function(){
        showMember($(this).val());
        $(this).val("");
    });
    $("#staff_name").bind("keydown","return",function(){
        showStaff($(this).val());
        $(this).val("");
    });
    $("#table_list").height($("#page-content").height()-$("#wrap").height()+$("#table_list").height());
    $("#_table").fixTable();
    createSN();
    docEvent($(document));
    docEvent($("#goods"));
});
function docEvent(obj){
    obj.bind("keydown","f2",function(){
        getNoCheck();
    }).bind("keydown","f4",function(){
        $("#member_card").focus();
    }).bind("keydown","f7",function(){
        $("#staff_name").focus();
    }).bind("keydown","insert",function(){
        editGoods($("#_table").children("tbody").find("tr.active"));
    }).bind("keydown","ctrl+return",function(){
        showCheck();
    }).bind("keydown","return",function(){
        $("#goods").focus();
    }).bind("keydown","up",function(){
        var s = $("#_table").children("tbody").find("tr.active");
        if(s.length) {
            var p = s.prev("tr");
            if(p.length) {
                s.removeClass("active");
                p.addClass("active");
                $("#_table").parent().scrollTop(p.prevAll("tr").length*p.height());             
            }
        } else {
            $("#_table").children("tbody").find("tr:last-child").addClass("active");
        }
    }).bind("keydown","down",function(){
        var s = $("#_table").children("tbody").find("tr.active");
        if(s.length) {
            var n = s.next("tr");
            if(n.length) {
                s.removeClass("active");
                n.addClass("active");
                $("#_table").parent().scrollTop(n.prevAll("tr").length*n.height());
            }
        } else {
            $("#_table").children("tbody").find("tr:first-child").addClass("active");
        }        
    }).bind("keydown","del",function(){
        delGoods($("#_table").children("tbody").find("tr.active").attr("row_id"));
    });
}
function createSN(){
    $.get('<?php echo url('Sale','creatrSN')?>',function(d){$("#sn").val(d);});
}
function newSN(){
    $("#sn").val('');
    $("#member_id").val('');
    $("#member_card").val('');
    $("#member_name").val('');
    $("#member_level").val('');
    $("#member_point").val('');
    $("#_table tbody tr").remove();
    $("#_table tfoot tr:first th:eq(1)").html("");
    $("#_table tfoot tr:first th:eq(2)").html("");
    $("#_table_table_tfoot tfoot tr:first th:eq(1)").html("");
    $("#_table_table_tfoot tfoot tr:first th:eq(2)").html("");
    $("#goods").focus();
    createSN();
}
function showGoods(kw){
    $.getJSON('<?php echo url('Sale','goods')?>',{kw:kw,shop_id:'<?php echo session('shop_id')?>',member_id:$("#member_id").val()},function(d){
        if(!d || d.length<1) {
            showMsg("未找到商品！",function(){$("#goods").focus()});
            return;
        }
        if(d.length==1) {
            addGoods(d[0]);
        }else if(d.length>1) {
            saleModal("选择商品",
            [["编号","id"],["编号","sku","1"],
            ["商品","name","1"],
            ["规格","spec","1"],
            ["折扣","discount","1"],
            ["售价","price_sell","1"],
            ["库存","stock_num","1"]],
            d,function(d){addGoods(d)});
        }   
    });
}
function showMember(kw){
    $.getJSON('<?php echo url('Sale','member')?>',{kw:kw},function(d){
        if(!d || d.length<1) {
            showMsg("未找到会员！",function(){$("#member_card").select()});
            $("#member_id").val('');
            $("#member_card").val('');
            $("#member_name").val('');
            $("#member_level").val('');
            $("#member_point").val('');
            $("#member_money").val('');
            return;
        }
        if(d.length==1) {
            addMember(d[0]);
        }else if(d.length>1) {
            saleModal("选择会员",
            [["编号","id"],
            ["卡号","card","1"],
            ["姓名","name","1"],
            ["电话","phone","1"],
            ["店铺","shop_name","1"],
            ["级别","level_name","1"],
            ["消费","consume","1"],
            ["积分","point","1"],
            ["预存","money"]],
            d,function(d){addMember(d)});
        }
    });
}
function showStaff(kw){
    $.getJSON('<?php echo url('Sale','staff')?>',{kw:kw},function(d){
        if(!d || d.length<1) {
            showMsg("未找到员工！",function(){$("#staff_name").focus()});
            $("#staff_id").val('');
            $("#staff_name").val('');
            return;
        }
        if(d.length==1) {
            $("#staff_id").val(d[0]['id']);
            $("#staff_name").val(d[0]['name']);
        }else if(d.length>1) {
            saleModal("选择员工",
            [["编号","id"],
            ["店铺","shop_name","1"],
            ["姓名","name","1"],
            ["电话","phone","1"]],
            d,function(d){
                $("#staff_id").val(d['id']);
                $("#staff_name").val(d['name']);
            });
        }
        $("#goods").focus();
    });
}
function getNoCheck(){
    if($("#staff_id").val()=='') {
        showMsg("请选择员工!",function(){$("#staff_name").select()});
        return;
    }
    if($("#_table tbody tr").length||$("#member_id").val()) {
        newSN();
        return;
    }
    $.getJSON('<?php echo url('Sale','getNoCheck')?>',{shop_id:'<?php echo session('shop_id')?>',staff_id:$("#staff_id").val()},function(d){
        if( !d || d.length<1) {
            showMsg("未找到挂单！",function(){$("#goods").focus()});
            $("#sn").val('');
            $("#member_id").val('');
            $("#member_card").val('');
            $("#member_name").val('');
            $("#member_level").val('');
            $("#member_point").val('');
            $("#member_money").val('');
            createSN();
            return;
        }
        if(d.length==1) {
            $("#sn").val(d[0]["sn"]);
            $("#member_id").val(d[0]['member_id']);
            $("#member_card").val(d[0]['member_card']);
            $("#member_name").val(d[0]['member_name']);
            $("#member_level").val(d[0]['member_level']);
            $("#member_point").val(d[0]['member_point']);
            $("#member_money").val(d[0]['member_money']);
        }else if(d.length>1) {
            saleModal("选择挂单",
            [["店铺","shop_name","1"],
            ["时间",function(d){return date('Y-m-d H:i:s',d["create_time"])},"1"],
            ["单号","sn","1"],
            ["卡号","member_card","1"],
            ["会员","member_name","1"],
            ["员工","staff_name","1"],
            ["操作","user_name","1"],
            ["编号","member_id"],
            ["级别","member_level"],
            ["积分","member_point"],
            ["预存","member_money"]],
            d,function(d){
                $("#sn").val(d["sn"]);
                $("#member_id").val(d['member_id']);
                $("#member_card").val(d['member_card']);
                $("#member_name").val(d['member_name']);
                $("#member_level").val(d['member_level']);
                $("#member_point").val(d['member_point']);
                $("#member_money").val(d['member_money']);
            });
        }
        loadGoods();
    });
}
function showCheck(){
    if($("#_table tbody tr").length<1) {
        showMsg("商品为空！",function(){$("#goods").focus()});
        return;
    }
    if($("#staff_id").val()=="") {
        showMsg("员工为空！",function(){$("#staff_name").focus()});
        return;
    }
    $('#sale_modal').one('show.bs.modal',function(e){
        var hyyc=parseFloat($("#member_money").val()||0.00),ysje=parseFloat($("#_table tfoot tr:first th:eq(2)").html()),ys=decFormat(ysje);
        $(this).find(".modal-title").html("结账");
        $(this).find(".modal-body").html(tmpl($('#modal-check').html(),{ysje:ys,yhje:ysje,hyyc:hyyc}));
        $(this).find("button[name=footer-ok]").html("结账(&crarr;)").unbind("click").click(function(){doCheck()});
        $(this).find("input[name=skfs][value=0]").click(function(){
            $('#sale_modal').find("#ysje").val(ys);
            $('#sale_modal').find("#hyyc").val(hyyc);
            $('#sale_modal').find("#ssje").val("0").keyup().val("");
        });
        $(this).find("input[name=skfs][value=1]").click(function(){
            $('#sale_modal').find("#ysje").val(ys);
            $('#sale_modal').find("#hyyc").val(hyyc);
            $('#sale_modal').find("#ssje").val(ys).keyup();
        });
        $(this).find("input[name=skfs][value=2]").click(function(){
            if(hyyc>ys){
                $('#sale_modal').find("#ysje").val("0.00");
                $('#sale_modal').find("#hyyc").val(subtract(hyyc,ys));
            }else{
                $('#sale_modal').find("#hyyc").val("0.00");
                $('#sale_modal').find("#ysje").val(subtract(ys,hyyc));
            }
            $('#sale_modal').find("#ssje").val("0").keyup().val("");
        });
        $(this).find("#ssje").unbind("keyup").bind("keyup",function(){
            if(isNaN($(this).val())){$(this).val("")}
            var ssje=$(this).val()||0,mlje=subtract(ysje,ys);
            var yhje=add(subtract(parseFloat($("#ysje").val()),parseFloat(ssje)),mlje);;
            if(yhje>0){$("#yhje").val(yhje)}else{$("#yhje").val(mlje)}
            var zlje=subtract(parseFloat($(this).val()),parseFloat($("#ysje").val()));
            if(zlje>0){$("#zlje").val(zlje)}else{$("#zlje").val("0.00")}
        }).unbind("keydown").bind("keydown","return",function(){
            doCheck();
        }).bind("keydown","ctrl+m",function(){
            $('#sale_modal').find("input[name=skfs][value=0]").click();
        }).bind("keydown","ctrl+b",function(){
            $('#sale_modal').find("input[name=skfs][value=1]").click();
        }).bind("keydown","ctrl+c",function(){
            $('#sale_modal').find("input[name=skfs][value=2]").click();
        });
    }).one('shown.bs.modal',function(e){
        $("#ssje").select();
    }).one("hidden.bs.modal",function(){
        $("#goods").select();
    }).bind("keyup","return",function(){
        $("#ssje").select();
    }).modal('show');
}
function decFormat(num){
    var m=Math.pow(10,<?php echo (int)option('sale_round')?>);
    if('<?php echo option('sale_type')?>'=='0') {
        return Math.floor(num*m)/m;
    }
    return Math.round(num*m)/m;
}
function doCheck(){
    if(isNaN($("#ssje").val())) {
        showMsg('请输入金额！');
        return;
    }
    var yh = subtract(parseFloat($("#ssje").val()||0),parseFloat($("#ysje").val()));
    if( yh<0 ) {
        $("#msg_modal").css('zIndex','10500').find(".modal-body").removeClass("alert-success alert-danger").html(tmpl($("#modal-alert").html(),{'body':('确定要优惠'+$("#yhje").val()+' ?')}));
        $("#msg_modal").one("show.bs.modal",function(){$(this).unbind("keydown")}).one("shown.bs.modal",function(){$(this).bind("keydown","return",function(){$(this).modal('hide');_doCheck()})}).one("hidden.bs.modal",function(){$(this).unbind("keydown");$("#ssje").select()}).modal({show:true,backdrop:false});
        $("#msg_modal").find("button[name=footer-ok]").one("click",function(){$(this).modal('hide');_doCheck()});   
        return;
    }
    _doCheck();
}
function _doCheck(){
    $.ajax({
        type:'POST',
        dataType:'json',
        url:'<?php echo url('Sale','save')?>',
        data:{
            sn:$('#sn').val(),
            staff_id:$("#staff_id").val(),
            staff_name:$("#staff_name").val(),
            member_id:$("#member_id").val(),
            member_card:$("#member_card").val(),
            member_name:$("#member_name").val(),
            member_level:$("#member_level").val(),
            member_point:$("#member_point").val(),
            member_money:$("#member_money").val(),
            skfs:$("#skfs").val(),
            ysje:$("#ysje").val(),
            hyyc:$("#hyyc").val(),
            ssje:$("#ssje").val(),
            yhje:$("#yhje").val(),
            zlje:$("#zlje").val()
        },
        error:function(){
            showMsg('系统错误!');
        },
        success:function(d){
            if(d.state) {
                showSuccess(d.info);
                $('#sale_modal').modal('hide');
                newSN();
            } else {
                showError(d.info);                    
            } 
        }
    });
}
function saleModal(title,columns,data,cb) {    
    $('#sale_modal').one('show.bs.modal',function(e){
        $(this).find(".modal-title").html(title);
        $(this).find(".modal-body").html(tmpl($('#modal-common').html(),{'columns':columns,'data':data}));
        $(this).find("tbody>tr").click(function(){
            $('#sale_modal').find("tr.active").removeClass("active");
            $(this).addClass("active");
        }).dblclick(function(){
            if (typeof cb === 'function') {
                var r = {};
                $('#sale_modal').find("tr.active").find("td").each(function(index){r[columns[index][1]]=$.trim($(this).html())});
                cb.call( this, r );
            }
            $('#sale_modal').modal('hide');
        });
    }).one("hidden.bs.modal",function(){
        $(this).unbind("keydown");
        $("#goods").select();
    }).bind("keydown","return",function(){
        if (typeof cb === 'function') {
            var r = {};
            $(this).find("tr.active").find("td").each(function(index){r[columns[index][1]]=$.trim($(this).html())});
            cb.call( this, r );
        }
        $(this).modal('hide');
    }).bind("keydown","up",function(){
        var s = $(this).find("tr.active");
        if(s.length) {
            var p = s.prev("tr");
            if(p.length) {
                s.removeClass("active");
                p.addClass("active");
                $(this).find(".table-content").scrollTop(p.prevAll("tr").length*p.height());             
            }
        } else {
            $(this).find("tr:last-child").addClass("active");
        }
    }).bind("keydown","down",function(){
        var s = $(this).find("tr.active");
        if(s.length) {
            var n = s.next("tr");
            if(n.length) {
                s.removeClass("active");
                n.addClass("active");
                $(this).find(".table-content").scrollTop(n.prevAll("tr").length*n.height());
            }
        } else {
            $(this).find("tr:first-child").addClass("active");
        }        
    }).modal('show');
}
function addMember(d){
    $.post('<?php echo url('Sale','addMember')?>',{
        staff_id:$("#staff_id").val(),
        staff_name:$("#staff_name").val(),
        member_id:d['id'],
        member_card:d['card'],
        member_name:d['name'],
        member_level:d['level_name'],
        member_point:d['point'],
        member_money:d['money'],
        sn:$('#sn').val()
    },function(r){
        $("#member_id").val(d['id']);
        $("#member_card").val(d['card']);
        $("#member_name").val(d['name']);
        $("#member_level").val(d['level_name']);
        $("#member_point").val(d['point']);
        $("#member_money").val(d['money']);
        loadGoods();
    });
}
function addGoods(d, last){
    if($('#sn').val()=='') {
        showMsg('流水号出错!',function(){$("#goods").focus()});
        return;
    }
    if(!<?php echo option('minus_stock')?>&&d['stock_num']<1){
        showMsg('不允许销售负库存商品!',function(){$("#goods").focus()});
        return;
    }
    $.post('<?php echo url('Sale','addGoods')?>',{
        goods_id:d['id'],
        staff_id:$("#staff_id").val(),
        staff_name:$("#staff_name").val(),
        member_id:$("#member_id").val(),
        member_card:$("#member_card").val(),
        member_name:$("#member_name").val(),
        member_level:$("#member_level").val(),
        member_point:$("#member_point").val(),
        member_money:$("#member_money").val(),
        discount:d['discount'],
        amount:'1',
        price:d['price_sell'],
        sn:$('#sn').val()
    },function(r){
        loadGoods();
    });
}
function doEditGoods(){
    if(!<?php echo option('minus_stock')?>&&
        parseFloat($("#edit_amount").val())>parseFloat($("#edit_stock_num").val())){
        showMsg('不允许销售负库存商品!',function(){$("#edit_amount").select();});
        return;
    }
    $.post('<?php echo url('Sale','editGoods')?>',{
        id:$("#edit_row_id").val(),
        discount:$("#edit_discount").val(),
        amount:$("#edit_amount").val(),
        price:$("#edit_price").val()
    },function(r){
        $('#sale_modal').modal('hide');
        loadGoods();
    }); 
}
function editGoods(obj){
    if($('#sn').val()=='') {
        showMsg('流水号出错!',function(){$("#goods").focus();});        
        return;
    }
    $('#sale_modal').one('show.bs.modal',function(e){
        $(this).find(".modal-header").show();
        $(this).find(".modal-title").html("修改数量/价格");
        $(this).find(".modal-body").html(tmpl($('#modal-edit-goods').html(),{
            'row_id':obj.attr("row_id"),
            'goods_sku':obj.find('td').eq(1).html(),
            'goods_name':obj.find('td').eq(2).html(),
            'goods_spec':obj.find('td').eq(3).html(),
            'goods_unit':obj.find('td').eq(4).html(),
            'discount':obj.find('td').eq(5).html(),
            'price':obj.find('td').eq(6).html(),
            'amount':obj.find('td').eq(7).html(),
            'total':obj.find('td').eq(8).html(),
            'stock_num':obj.find('td').eq(9).html()
        }));
        $(this).find("button[name=footer-ok]").html("修改(&crarr;)").unbind("click").click(function(){doEditGoods()});
        $(this).find("#edit_amount").bind("keyup","return",function(){doEditGoods()});
        $(this).find("#edit_price").bind("keyup","return",function(){doEditGoods()});
    }).bind("keyup","return",function(){
        doEditGoods();
    }).one('shown.bs.modal',function(e){
        $("#edit_amount").select();
    }).one("hidden.bs.modal",function(){
        $("#goods").focus();
    }).modal('show');
}
function loadGoods(){
    $.getJSON('<?php echo url('Sale','getGoods')?>',{sn:$('#sn').val()},function(d){
        var tr=[],amount=0,total=0;
        for(var i=0; i<d.length; i++) {            
            tr.push('<tr row_id="'+d[i]['id']+'">');
            tr.push('<td>' + (i+1) + '</td>');
            tr.push('<td>' + d[i]['goods_sku'] + '</td>');
            tr.push('<td>' + d[i]['goods_name'] + '</td>');
            tr.push('<td>' + d[i]['goods_spec'] + '</td>');
            tr.push('<td>' + d[i]['goods_unit'] + '</td>');
            tr.push('<td>' + d[i]['discount'] + '</td>');
            tr.push('<td>' + d[i]['price'] + '</td>');
            tr.push('<td>' + d[i]['amount'] + '</td>');
            tr.push('<td>' + d[i]['total'] + '</td>');
            tr.push('<td>' + d[i]['stock'] + '</td>');
            tr.push('<td><div class="btn-group"><a style="cursor:pointer" onclick="delGoods(\'' + d[i]['id'] + '\')" title="删除"><i class="fa fa-trash-o"></i><span class="hidden-sm">删除</span></a></div></td>');
            tr.push('</tr>');
            amount = add(amount,parseFloat(d[i]['amount']));
            total = add(total,parseFloat(d[i]['total']));
        }
        $("#_table tbody").html(tr.join('')).find("tr").unbind('click').click(function(){$('#_table').find("tr.active").removeClass("active");$(this).addClass("active");}).unbind('dblclick').dblclick(function(){editGoods($(this))});
        $("#_table tbody tr:last").addClass('active');
        var tfoot = $("#_table tfoot tr:first");tfoot.find("th:eq(1)").html(amount);tfoot.find("th:eq(2)").html(total);
        var ttfoot = $("#_table_table_tfoot tfoot tr:first");ttfoot.find("th:eq(1)").html(amount);ttfoot.find("th:eq(2)").html(total);
        $("#_table").parent().scrollTop($("#_table").parent().height());
        $("#_table").fixTableWidth();
        $("#goods").focus();
    });
}
function delGoods(id){
    $.get('<?php echo url('Sale','delGoods')?>',{id:id},function(){loadGoods()});
}
</script>
</body>
</html>