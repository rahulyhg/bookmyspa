<script>
$(document).ready(function(){
    var $modal = $('#commonSmallModal');
    var list = [3,4];
    var itsId  = "";
    
    $(document).on('click','.delete_videosetup' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm('Are you sure, you want to delete this Video?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'videosetup','action'=>'deleteVideoSetup','admin'=>true)); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                    $(".videoSetupDataView").load("<?php echo $this->Html->url(array('controller'=>'videosetup','action'=>'index')); ?>", function() {
                    });
		}
            });
        }
    });
    var chkPtyp = true;
    $(document).on('click','.addedit_videosetup' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Videosetup','action'=>'admin_add_videosetup')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL,'VideoSetupAdminAddVideosetupForm');
        chkPtyp = true;
    });
    $modal.on('click', '.update', function(e){
        var theBtn = $(this);
	buttonLoading(theBtn);
        var options = { 
            success:function(res){
                buttonSave(theBtn);
		theBtn.addClass('rqt_already_sent');
                if(onResponse($modal,'VideoSetup',res)){
                    $(".videoSetupDataView").load("<?php echo $this->Html->url(array('controller'=>'videosetup','action'=>'index')); ?>", function() {
                    });    
                }else{
                    chkPtyp = true;
                }
            }
        };
        if(!theBtn.hasClass('rqt_already_sent')){
                $('#VideoSetupAdminAddVideosetupForm').submit(function(){
        	$(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        }
        setTimeout(function(){
            if($modal.find('dfn.text-danger').length > 0){
                $modal.find('div.tab-pane').removeClass('active');
                $modal.find('div.tab-pane#tab1').addClass('active');
                $modal.find('ul.nav li').removeClass('active');
                $modal.find('ul.nav a[href=#tab1]').closest('li').addClass('active');
                buttonSave(theBtn);
            }
        },500);
        
    });
    $(document).on('click','.changeStatus',function(){
            var theJ = $(this);
            var theId = theJ.closest('tr').attr('data-id');
            var statusTo = theJ.attr('data-status');
            
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'videosetup','action'=>'videoSetupChangeStatus','admin'=>true));?>",
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
<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Video Setup
                </h3>
                <?php 
                 echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_videosetup pull-right'));?>
            </div>
            <div class="box-content">
                <div class="videoSetupDataView" id="list-types">
		    <?php echo $this->element('admin/Videosetup/video_listing'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //echo $this->element('sql_dump'); ?>