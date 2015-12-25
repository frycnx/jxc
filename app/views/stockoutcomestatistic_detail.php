            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">库存流水</h4>
            </div>
            <div class="modal-body">
<div class="row">
<div class="col-xs-12">
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="stock_table">
    <thead>
        <tr>
        <th>日期</th>
        <th>SKU</th>
        <th>商品</th>
        <th>店铺</th>
        <th>类型</th>
        <th>数量</th>
        <th>备注</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
</div>
<div class="row">
<div class="col-xs-4 text-left"><label class="control-label" id="stock_table_info"></label></div>
<div class="col-xs-8 text-right" id="stock_table_page"></div>
</div>
            </div>

<script type="text/javascript">
$("#stock_table").ajaxTable({
    "loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "stock_table_page",
    "pageInfoContainer": "stock_table_info",
    "url": '<?php echo url('StockOutcomeStatistic','detail',array('outcome_id'=>get('outcome_id')))?>',
    "columns": [
            {"name":"sku", "data": "sku"},
            {"name":"name", "data": "name"},
            {"name":"spec", "data": "spec"},
            {"name":"unit", "data": "unit"},
            {"name":"cate_name", "data": "cate_name"},
            {"name":"shop_name", "data": "shop_name"},
            {"name":"stock_num", "data": "stock_num", "sum": "stock_num"}
            ],
    "complete": function(d){
        $("#stock_table_page").find("a").click(function(){alert($(this).attr("href"));ajaxLoad($(this).attr("href"));return false;});
    }
});
</script>