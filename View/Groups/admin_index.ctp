<script>

$(document).ready(function(){
    <?php if($auth_user['User']['type'] != 1){ ?>
        var list = [2,3];
    <?php }
    else{ ?>
        var list = [5,6];
    <?php } ?>
    
    //var $modal = $('#commonSmallModal');
    var $modal = $('#commonContainerModal');
    var itsId  = "";
    $(document).on('click','.addedit_group' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'add')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL);
    });
    
    $(document).on('click','.view_group' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'view')); ?>";
        var $bigmodal = $('#commonContainerModal');
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($bigmodal,addeditURL);
    });
    
    $(document).on('click','.delete_group' ,function(){
        var itsId = $(this).closest('tr').attr('data-id');
        if(confirm(' Are you sure, you want to delete this Group?')){
            $.ajax({
            url: "<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'delete')); ?>",
            type:'POST',
            data:{'id': itsId }
            }).done(function(response){
                var data = jQuery.parseJSON(response);
                if(data.data == 'success'){
                    var ie11andabove = navigator.userAgent.indexOf('Trident') != -1 && navigator.userAgent.indexOf('MSIE') == -1;
                    var ie10andbelow = navigator.userAgent.indexOf('MSIE') != -1;
                    if(ie11andabove || ie10andbelow){
                            window.location.reload();
                            return false;
                    
                    }
                     $(".groupdataView").load("<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'index')); ?>", function() {
                        datetableReInt($(document).find('.dataTable'),list);
                    });
                }
                onResponseBoby(response);
            });
        }
    });
    
    $(document).on('click','.changeStatus',function(){
        var theJ = $(this);
        var theId = theJ.closest('tr').attr('data-id');
        var statusTo = theJ.attr('data-status');
        
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'changeStatus','admin'=>true));?>",
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
    });
    
    
    $(document).on('click','.edit_accessLevel' ,function(){
        var itsId = $(this).attr('data-id');
        var addeditURL = "<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'assign_access_level')); ?>";
        addeditURL = addeditURL+'/'+itsId
        // function in modal_common.js
        fetchModal($modal,addeditURL);
    });
     
    $modal.on('click', '.update', function(e){
        var options = { 
            //beforeSubmit:  showRequest,  // pre-submit callback 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'Group',res)){
                    var ie11andabove = navigator.userAgent.indexOf('Trident') != -1 && navigator.userAgent.indexOf('MSIE') == -1;
                    var ie10andbelow = navigator.userAgent.indexOf('MSIE') != -1;
                    if(ie11andabove || ie10andbelow){
                            window.location.reload();
                            return false;
                    
                    }
                    $(".groupdataView").load("<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'index')); ?>", function() {
                       datetableReInt($(document).find('.dataTable'),list);
                    });    
                }
            }
        }; 
        $('#GroupAdminAddForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    
    $modal.on('click', '.access_update', function(e){
        var options = { 
            success:function(res){
                // onResponse function in modal_common.js
                if(onResponse($modal,'Group',res)){
                    $(".groupdataView").load("<?php echo $this->Html->url(array('controller'=>'Groups','action'=>'index')); ?>", function() {
                        //$(document).find('table.dataTable').dataTable().fnDestroy();
                        //datetableReInt($(document).find('table.dataTable'),list);
                        window.location.reload();
                    });    
                }
            }
        }; 
        $('#GroupAdminAssignAccessLevelForm').submit(function(){
            $(this).ajaxSubmit(options);
            $(this).unbind('submit');
            $(this).bind('submit');
            return false;
        });
    });
    
    //Set the logout time for salon an its staff
    $("#logout_time").change(function(){
        $.ajax({
            url: 'Groups/set_logout_time',
            type: 'POST',
            data: {logout_time : this.value},
            success: function(data) {
                window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });

        
    });
    
    
    datetableReInt($(document).find('table.dataTable'),list);
});

</script>

<div class="row-fluid">
    <div class="span12">
        <div class="box box-color box-bordered">
            <div class="box-title">
                <h3>
                    <i class="icon-table"></i>
                    Access Levels
                </h3>
                <?php if($userType == Configure::read('SUPERADMIN_ROLE') || $userType == Configure::read('FRANCHISE_ROLE') ||
                         $userType == Configure::read('MULTILOCTION_ROLE') || $userType == Configure::read('SALON_ROLE')) {
                echo $this->Html->link('<button class="btn"><i class="icon-plus"></i> Add New</button>','javascript:void(0);',array('data-id'=>'','escape'=>false,'class'=>'addedit_group pull-right'));
                } ?>
                <div class="pull-right">
                <?php if($userType != Configure::read('SUPERADMIN_ROLE')) {
                    echo '<div class="automatic-txt">Automatic logout after:</div> ';
                    echo $this->Form->input('logout_time', array(
                        'options'=>array('1' => '1 minute', '2'=> '2 minutes', '5'=> '5 minutes', '10'=> '10 minutes',
                                         '15'=> '15 minutes', '30'=> '30 minutes', '45'=> '45 minutes', '60'=> '60 minute',
                                         '90' => '90 minutes', '120'=> '120 minutes', '0'=> 'Never'),
                        'selected'=> $salon_logout['Salon']['logout_time'],
                        'class'=>'input-sm mrgn-rgt10 pull-right', 
                        'id' => 'logout_time',
                        'default' =>60,
                        'label'=> false, 'div'=> false
                    ));
                }
                ?>
                </div>
            </div>
            <div class="box-content">
                <div class="groupdataView">
                    <?php echo $this->element('admin/Group/list_group'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('sql_dump');?>