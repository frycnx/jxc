<!-- Modal -->
<div class="modal fade" id="customer_modal" tabindex="-1" role="dialog" aria-labelledby="customer_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">选择客户</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form class="form-inline" id="customer_modal_table_search">
                        <div class="form-group">
                        <input type="text" name="kw" class="form-control" placeholder="关键词...">
                        <input type="submit" class="btn" value="搜索"/>
                        </div>
                        </form>
                    </div>				
                <div class="col-xs-12">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover table-condensed" id="customer_modal_table">
                        <thead>
                            <tr>
                            <th>编号</th>
                            <th>名称</th>                            
                            <th>联系人</th>
                            <th>电话</th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                            <th style="display:none"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-4 text-left">
                    <label class="control-label" id="customer_modal_table_info"></label>
                </div>
                <div class="col-xs-8 text-right" id="customer_modal_table_page"></div>
              </div>
           </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
$('#customer_modal').on('show.bs.modal',function(e){
        if(!$('#shop_id').val()) {
            showMsg('请先选择店铺！');
            return false;
        }
}).on('shown.bs.modal',function(e){
    $("#customer_modal_table_opt tbody").empty();
    $("#customer_modal_table").ajaxTable({
        "loading":'<img src="static/img/loading.gif"/>',
        "pageContainer": "customer_modal_table_page",
        "pageInfoContainer": "customer_modal_table_info",
        "searchForm": "customer_modal_table_search",
        "url": '<?php echo url('Trade','customer')?>',
        "data": {shop_id:$('#shop_id').val()},
        "columns": [
                {"name":"id", "data": "id", "attr": "style='display:none'"},
                {"name":"sn", "data": "sn"},
                {"name":"name", "data": "name"},
                {"name":"contact", "data": "contact" },
                {"name":"phone", "data": "phone" },
                {"name":"money", "data": "money", "attr": "style='display:none'"},
                {"name":"overdraft", "data": "overdraft", "attr": "style='display:none'"},
                {"name":"offer", "data": "offer", "attr": "style='display:none'"},
                {"name":"consume", "data": "consume", "attr": "style='display:none'"}
            ],
        "complete": function(cb){
            $("#customer_modal_table tbody tr").dblclick(function(){
                if(typeof customerModalFinish == "function") {
                    customerModalFinish({
                        id:$(this).children("td:eq(0)").html(),
                        sn:$(this).children("td:eq(1)").html(),
                        name:$(this).children("td:eq(2)").html(),
                        contact:$(this).children("td:eq(3)").html(),
                        phone:$(this).children("td:eq(4)").html(),
                        money:$(this).children("td:eq(5)").html(),
                        overdraft:$(this).children("td:eq(6)").html(),
                        offer:$(this).children("td:eq(7)").html(),
                        consume:$(this).children("td:eq(8)").html()
                    });
                }
                $("#customer_modal").modal('hide');
                $("#customer_modal_table_opt tbody").empty();
            });
        }
    });
});
</script>