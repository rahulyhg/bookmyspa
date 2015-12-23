<?php
echo $this->Html->css('admin/plugins/tagsinput/jquery.tagsinput.css');
echo $this->Html->script('admin/plugins/tagsinput/jquery.tagsinput.min.js');
echo $this->Html->script('admin/plugins/gmap/gmap3.min.js');
echo $this->Html->script('admin/plugins/gmap/gmap3-menu.js');
?>
<script>
	$( document ).ready(function() {
		$(document).on('click', '.CustomerHistory', function(e){
			var customerHistoryURL = "<?php echo $this->Html->url(array('controller'=>'appointments','action'=>'getCustomerHistory','admin'=>true)); ?>";
			var itsId = $(this).attr('user-id');
			//alert(itsId);
			fetchModal($appModal,customerHistoryURL+'/'+itsId);
				//$usermodal.find('.submitUser').unbind( "click" );
		});
		$usermodal = $(document).find('#commonContainerModal');
		$(document).on('click','.addeditUser',function(){
            var addUserURL = "<?php echo $this->Html->url(array('controller'=>'users','action'=>'addUser','admin'=>true)); ?>";
            var itsId = $(this).attr('data-id');
            fetchModal($usermodal,addUserURL+'/'+itsId);
            $usermodal.find('.submitUser').unbind( "click" );
        });
		
		$usermodal.on('click', '.submitUser', function(e){
            var options = { 
                success:function(res){
                    if(onResponse($usermodal,'User',res)){
                        var data = jQuery.parseJSON(res);
                        onSelectChange(data.id)
                    }
                }
            }; 
            $('#UserAdminAddUserForm').submit(function(){
                $(this).ajaxSubmit(options);
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        });
		
	});

	function getCustomerHistory($appModal,eventId){
        var GetCustomerHistoryURL = "<?php echo $this->Html->url(array('controller'=>'Appointments','action'=>'getCustomerHistory','admin'=>true)); ?>";
        GetCustomerHistoryURL  = GetCustomerHistoryURL +'/'+eventId; 
        fetchModal($appModal,GetCustomerHistoryURL);
    }
	
	
</script>
