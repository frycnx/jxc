<div class="modal fade" id="msg_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
function showMsg(msg, cb, t){
    $("#msg_modal").css('zIndex','10500').find(".modal-body").removeClass("alert-success alert-danger").html(msg);
    if(typeof cb === 'function'){$("#msg_modal").one("hidden.bs.modal",function(){cb.call( this)})}
    $("#msg_modal").modal({show:true,backdrop:false});    			  
    window.setTimeout(function(){$('#msg_modal').modal('hide')},t||1000);
}
function showError(msg, cb, t){
    $("#msg_modal").css('zIndex','10500').find(".modal-body").removeClass("alert-success").addClass("alert-danger").html(msg);
    if(typeof cb === 'function'){$("#msg_modal").one("hidden.bs.modal",function(){cb.call( this)})}
    $("#msg_modal").modal({show:true,backdrop:false});
    window.setTimeout(function(){$('#msg_modal').modal('hide')},t||1000);
}
function showSuccess(msg, cb, t){
    $("#msg_modal").css('zIndex','10500').find(".modal-body").removeClass("alert-danger").addClass("alert-success").html(msg);
    if(typeof cb === 'function'){$("#msg_modal").one("hidden.bs.modal",function(){cb.call( this)})}
    $("#msg_modal").modal({show:true,backdrop:false});
    window.setTimeout(function(){$('#msg_modal').modal('hide')},t||1000);
}
function closeMsg(){
    $('#msg_modal').modal('hide');
}
</script>