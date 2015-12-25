<!-- Modal -->
<div class="modal fade" id="multi_goods_modal" tabindex="-1" role="dialog" aria-labelledby="goods_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">选择商品</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-sm-7">
                        <div class="row">
                        <div class="col-xs-12">
                        <form class="form-inline" id="multi_goods_modal_table_search">
                        <div class="form-group">
                        <select size="1" class="form-control" name="cate_id" id="multi_goods_modal_cate_id"></select>
                        <input type="text" name="kw" class="form-control" placeholder="商品名...">
                        <input type="submit" class="btn" value="搜索"/>
                        </div>
                        </form>
                        </div>				
                        <div class="col-xs-12">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="multi_goods_modal_table">
                            <thead>
                                <tr>
                                <th style="display:none">编号</th>
                                <th>SKU</th>
                                <th>商品</th>
                                <th>规格</th>
                                <th style="display:none">条码</th>
                                <th style="display:none">分类</th>                                    
                                <th>售价</th>
                                <th>库存</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                        <div class="col-xs-4 text-left"><label class="control-label" id="multi_goods_modal_table_info"></label></div>
                        <div class="col-xs-8 text-right" id="multi_goods_modal_table_page"></div>
                       </div>
                       </div>
                      <div class="col-sm-5">
                        <div class="row">
                        <div class="col-xs-12 text-right">
                        <input type="button" class="btn" id="multi_goods_modal_finish" value="确定"/>
                        </div>					
                        <div class="col-xs-12">
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="multi_goods_modal_table_opt">
                            <thead>
                                <tr>
                                <th></th>
                                <th style="display:none">编号</th>
                                <th>SKU</th>
                                <th>商品</th>
                                <th>规格</th>
                                <th>折扣</th>
                                <th>价格</th>
                                <th>数量</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                        </div>
                    </div>
              </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Modal -->
<div class="modal fade" id="multi_goods_modal_amount" tabindex="-1" role="dialog" aria-labelledby="goods_modal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">输入数量</h4>
            </div>
            <div class="modal-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label text-center">SKU</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="id"/>
                        <input type="text" name="sku" required="required" class="form-control" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">名称</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">规格</label>
                    <div class="col-sm-9">
                        <input type="text" name="spec" class="form-control" readonly="readonly"/>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-sm-3 control-label">库存</label>
                    <div class="col-sm-9">
                        <input type="text" name="stock" class="form-control" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">折扣</label>
                    <div class="col-sm-9">
                        <input type="text" name="discount" class="form-control" readonly="readonly"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">价格</label>
                    <div class="col-sm-9">
                        <input type="text" name="price" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">数量</label>
                    <div class="col-sm-9">
                        <input type="text" name="amount" required="required" class="form-control" value="<?php echo $row['unit']?>"/>
                    </div>
                </div>
            </form>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" name="submit">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
$('#multi_goods_modal').on('show.bs.modal',function(e){
        if(!$('#shop_id').val()) {
            showMsg('请先选择店铺！');
            return false;
        }
}).on('shown.bs.modal',function(e){
    $("#multi_goods_modal_table_opt tbody").empty();
    $("#multi_goods_modal_table").ajaxTable({
        "loading":'<img src="static/img/loading.gif"/>',
        "pageContainer": "multi_goods_modal_table_page",
        "pageInfoContainer": "multi_goods_modal_table_info",
        "searchForm": "multi_goods_modal_table_search",
        "url": '<?php echo url('Trade','goods')?>',
        "data": {shop_id:$('#shop_id').val()},
        "columns": [
                {"name":"goods_id", "data": "id", "attr": "style='display:none'" },
                {"name":"goods_sku", "data": "sku"},
                {"name":"goods_name", "data": "name"},
                {"name":"spec", "data": "spec" },
                {"name":"barcode", "data": "barcode", "attr": "style='display:none'" },
                {"name":"cate_name", "data": "cate_name", "attr": "style='display:none'" },
                {"name":"price_sell", "data": "price_sell" },
                {"name":"stock_num", "data": "stock_num" }
            ],
        "complete": function(cb){
            $("#multi_goods_modal_table tbody tr").dblclick(function(){
                show_goods_modal_amount({
                    id:$(this).children("td:eq(0)").html(),
                    sku:$(this).children("td:eq(1)").html(),
                    name:$(this).children("td:eq(2)").html(),
                    spec:$(this).children("td:eq(3)").html(),
                    barcode:$(this).children("td:eq(4)").html(),
                    cate_name:$(this).children("td:eq(5)").html(),
                    price:$(this).children("td:eq(6)").html(),
                    stock:$(this).children("td:eq(7)").html(),
                    discount:'1'
                });
            });
        }
    });
    $("#multi_goods_modal_finish").click(function(){
        if(typeof multiGoodsModalFinish == "function") {
            var d = [];
            $("#multi_goods_modal_table_opt tbody tr").each(function(i){
                d.push({
                    id:$(this).children("td:eq(1)").html(),
                    sku:$(this).children("td:eq(2)").html(),
                    name:$(this).children("td:eq(3)").html(),
                    spec:$(this).children("td:eq(4)").html(),
                    discount:$(this).children("td:eq(5)").html(),
                    price:$(this).children("td:eq(6)").html(),
                    amount:$(this).children("td:eq(7)").html()
                });
            });
            multiGoodsModalFinish(d);
        }
        $("#multi_goods_modal_amount").modal('hide');
        $("#multi_goods_modal").modal('hide');
        $("#multi_goods_modal_table_opt tbody").empty();
    });
    function show_goods_modal_amount(data, index){
        var obj = $("#multi_goods_modal_amount");
        $("input[name=id]",obj).val(data["id"]);
        $("input[name=sku]",obj).val(data["sku"]);
        $("input[name=name]",obj).val(data["name"]);
        $("input[name=spec]",obj).val(data["spec"]);
        $("input[name=price]",obj).val(data["price"]);
        $("input[name=stock]",obj).val(data["stock"]);
        $("input[name=discount]",obj).val(data["discount"]);
        $("input[name=amount]",obj).val('');
        $("button[name=submit]",obj).unbind("click").click(function(){
            var tr = '';
            tr += '<tr>';
            tr += '<td><a style="cursor:pointer" onclick="this.parentNode.parentNode.remove()" title="删除"><i class="fa fa-trash-o"></i></a></td>';
            tr += '<td style="display:none">'+$("input[name=id]",obj).val()+'</td>';
            tr += '<td>'+$("input[name=sku]",obj).val()+'</td>';
            tr += '<td>'+$("input[name=name]",obj).val()+'</td>';
            tr += '<td>'+$("input[name=spec]",obj).val()+'</td>';
            tr += '<td>'+$("input[name=discount]",obj).val()+'</td>';
            tr += '<td>'+$("input[name=price]",obj).val()+'</td>';
            tr += '<td>'+$("input[name=amount]",obj).val()+'</td>';
            tr += '</tr>';
            var obj_tr = $("#multi_goods_modal_table_opt tbody tr");
            if(!isNaN(index)) {
                obj_tr.eq(index).after(tr);
                obj_tr.eq(index).remove();                  
            }else{
                $("#multi_goods_modal_table_opt tbody").append(tr);
            }    
            obj_tr.each(function(i){
                $(this).unbind("dblclick").dblclick(function(){
                    show_goods_modal_amount({
                        id:$(this).children("td:eq(1)").html(),
                        sku:$(this).children("td:eq(2)").html(),
                        name:$(this).children("td:eq(3)").html(),
                        spec:$(this).children("td:eq(4)").html(),
                        discount:$(this).children("td:eq(5)").html(),
                        price:$(this).children("td:eq(6)").html()
                    }, i);
                });
            });
            obj.modal('hide');
        });
        obj.modal({show:true,backdrop:false})
            .on('shown.bs.modal',function(){
                $("input[name=amount]",obj).focus();
            });
    }
});
</script>