            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">订单详情</h4>
            </div>
            <div class="modal-body">
<div class="row">
<div class="col-xs-12">
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="sale_table">
    <thead>
        <tr>
        <th>SKU</th>
		<th>商品</th>
		<th>规格</th>
        <th>分类</th>
		<th>价格</th>
		<th>折扣</th>
        <th>数量</th>
        <th>总额</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>
</div>
<div class="row">
<div class="col-xs-4 text-left"><label class="control-label" id="sale_table_info"></label></div>
<div class="col-xs-8 text-right" id="sale_table_page"></div>
</div>
            </div>

<script type="text/javascript">
$("#sale_table").ajaxTable({
    "loading":'<img src="static/img/loading.gif"/>',
    "pageContainer": "sale_table_page",
    "pageInfoContainer": "sale_table_info",
    "url": '<?php echo url('TradeStatistic','detail',array('trade_id'=>get('trade_id')))?>',
    "columns": [
            {"name":"goods_sku", "data": "goods_sku"},
            {"name":"goods_name", "data": "goods_name"},
            {"name":"goods_spec", "data": "goods_spec"},
            {"name":"cate_name", "data": "cate_name"},
            {"name":"price", "data": "price"},
			{"name":"discount", "data": "discount"},
			{"name":"amount", "data": "amount", "sum": "amount"},
            {"name":"total", "data": "total", "sum": "total"}
            ],
    "complete": function(d){
        $("#sale_table_page").find("a").click(function(){alert($(this).attr("href"));ajaxLoad($(this).attr("href"));return false;});
    }
});
</script>
