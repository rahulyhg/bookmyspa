<script>

$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var itsId  = "";
    $(document).on('click','.addedit_room' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'StaticPages','action'=>'add_room')); ?>";
        addeditURL = addeditURL+'/'+itsId
        $('body').modalmanager('loading');
        // function in modal_common.js
        fetchModal($modal,addeditURL);
    });
  
    
    $(document).on('click','.delete_room' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this Room ? ')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'StaticPages','action'=>'delete_room')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                     $(".cmsdataView").load("<?php echo $this->Html->url(array('controller'=>'StaticPages','action'=>'room')); ?>", function() {
                        var list = [4];
                        datetableReInt($(document).find('.cmsdataView').find('table'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    $modal.on('click', '.update', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'SalonRoom',res)){
                    $(".cmsdataView").load("<?php echo $this->Html->url(array('controller'=>'StaticPages','action'=>'room')); ?>", function() {
                        var list = [4];
                        datetableReInt($(document).find('.cmsdataView').find('table'),list);
                    });    
                }
            }
        }; 
        $('#SalonRoomAdminAddRoomForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    var list = [4];
    datetableReInt($(document).find('.dataTable'),list);
});

</script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Rooms Listing
                </h3>
                <?php 
                echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_room pull-right'));?>
            </div>
            <div class="box-content">
                <div class="cmsdataView">
                    <?php echo $this->element('admin/Settings/list_admin_rooms'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'StaticPages','action'=>'changeStatus','admin'=>true));?>",
                data: { id: theId, status: statusTo }
            })
            .done(function( msg ) {
                if(msg == 0){
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(0); ?>')
                }
                else{
                    theJ.closest('td').html('<?php echo $this->Common->theStatusImage(1); ?>')
                }
            });
        })
    });
</script>