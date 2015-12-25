<!-- Modal -->
<div class="modal fade" id="one_goods_modal" tabindex="-1" role="dialog" aria-labelledby="goods_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">选择商品</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-xs-12">
                <form class="form-inline" id="one_goods_modal_table_search">
                <div class="form-group">
                <select size="1" class="form-control" name="cate_id">
                <option value="">---</option>
                <?php foreach($category as $key=>$val):?>
                <option value="<?php echo $key?>"><?php echo $val?></option>
                <?php endforeach?>
                </select>
                <input type="text" name="kw" class="form-control" placeholder="商品名...">
                <input type="submit" class="btn" value="搜索"/>
                </div>
                </form>
                </div>				
                <div class="col-xs-12">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="one_goods_modal_table">
                    <thead>
                        <tr>
                        <th style="display:none">编号</th>
                        <th>SKU</th>
                        <th>商品</th>
                        <th>规格</th>
                        <th>条码</th>
                        <th>分类</th>                                    
                        <th>售价</th>
                        <th>库存</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
                <div class="col-xs-4 text-left"><label class="control-label" id="one_goods_modal_table_info"></label></div>
                <div class="col-xs-8 text-right" id="one_goods_modal_table_page"></div>
               </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
$('#one_goods_modal').on('show.bs.modal',function(e){
        if(!$('#shop_id').val()) {
            showMsg('请先选择店铺！');
            return false;
        }
    }).on('shown.bs.modal',function(e){
    $("#one_goods_modal_table").ajaxTable({
        "loading":'<img src="static/img/loading.gif"/>',
        "pageContainer": "one_goods_modal_table_page",
        "pageInfoContainer": "one_goods_modal_table_info",
        "searchForm": "one_goods_modal_table_search",
        "url": '<?php echo url('Stock')?>',
        "data": {shop_id:$('#shop_id').val()},
        "columns": [
                {"name":"id", "data": "id", "attr": "style='display:none'" },
                {"name":"sku", "data": "sku"},
                {"name":"name", "data": "name"},
                {"name":"spec", "data": "spec" },
                {"name":"barcode", "data": "barcode" },
                {"name":"cate_name", "data": "cate_name" },
                {"name":"price_sell", "data": "price_sell" },
                {"name":"stock_num", "data": "stock_num" }
            ],
        "complete": function(cb){
            $("#one_goods_modal_table tbody tr").dblclick(function(){
                if(typeof oneGoodsModalFinish == "function") {
                    oneGoodsModalFinish({
                            id:$(this).children("td:eq(0)").html(),
                            sku:$(this).children("td:eq(1)").html(),
                            name:$(this).children("td:eq(2)").html(),
                            spec:$(this).children("td:eq(3)").html(),
                            barcode:$(this).children("td:eq(4)").html(),
                            cate_name:$(this).children("td:eq(5)").html(),
                            price_sell:$(this).children("td:eq(6)").html(),
                            stock_num:$(this).children("td:eq(7)").html(),
                            discount:'1'
                        });
                }
                $("#one_goods_modal").modal('hide');
            });
        }
    });
});
</script>