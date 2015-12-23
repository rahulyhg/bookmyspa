<div class="box">
    <div class="box-content side-gap no-gap">
	<div class="staff-head">
	    <?php echo $this->Html->link($this->Html->image('add-emp.png'). 'Add employee' ,array('controller'=>'SalonStaff' ,'action'=>'add','admin'=>true),array('escape'=>false,'class'=>'','alt'=>'Add Employee'));?>
	    <section class="search">
		<?php echo $this->Form->input('search' ,array('type'=>'search','div'=>false,'label'=>false,'placeholder'=>'Search','class'=>'searchStaff')); ?>
		<?php echo $this->Html->Image('admin/search-icon.png'); ?>
	    </section>
	</div>
	<div class="staff-content">
	    <p>This is the list of users on this account. You can turn on/off online booking, edit profiles, service hours/menu, and activate each user. <!--<a href="#">See how.</a>-->
	    </p>
                <div class="emp-detail-box" >
			<?php
                        $user  = $admin_user;
			$admin_salon_id = $user['User']['id'];
//                        pr($user);
                        if($user['User']['image']){ ?>
			    <div class="emp-photo added ">
			    <div class="tbl-box">
			    <div class="inner-tbl-box">
				<div class="img-change-option">
                                    <?php echo $this->Html->link('change','javascript:void(0)',array('data-div_id'=>$user['User']['id'],'class'=>'add_image')) ?>
                                    <?php echo $this->Html->link('delete','javascript:void(0)',array('data-div_id'=>$user['User']['id'], 'data-image_name'=>$user['User']['image'],'class'=>'delete_image')) ?>
				</div>
				<?php echo $this->Html->Image('/images/' . $user['User']['id'] . '/User/resized/' . $user['User']['image'],array('alt'=>'Image','title'=>'change Image')); ?>
			    </div> </div></div>
			<?php }else{ ?>    
				<a class="emp-photo add_image" data-div_id ="<?php echo $user['User']['id'] ?>"  href="javascript:void(0)">
				    <?php echo $this->Html->image('add-usephoto.png') ?>
				    <span>ADD PHOTO</span>
				</a>
			<?php } ?>
			<div class="emp-other-info">
			    <div class="emp-name-info">
				<div class="name-head">
				    <p class="staffName" ><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></p>
				    <ul>
                                   				    </ul>
				</div>
				<ul class="add-info">
				    <li>
					<label>Mobile 1</label>
					<section class="ans">
					     <?php  echo $user['Contact']['cell_phone']; ?>
					</section>
				    </li>
				    <li>
					<label>E-mail</label>
					<section class="ans">
					    <?php echo $user['User']['email'];?>
					</section>
				    </li>
				    <li>
					<label>Access Level</label>
					<section class="ans">
                                           Account Admin
					    <?php //echo $this->Common->get_access_level_name($user['User']['group_id']); ?> 
                                        </section>
				    </li>
				    <li>
				        <label>Pricing Level</label>
					<section class="ans">
					    <?php echo $this->Common->get_price_level_name($user['User']['id']); ?> 
					</section>
				    </li>
				</ul>
			    </div>
			    <div class="emp-extra-info">
				<ul>
                                    <?php //$class = ($user['UserDetail']['employee_type']=='1' || $user['UserDetail']['employee_type']==0)?'three':''; ?>
				    <li class="gray">
					<?php echo $this->Html->link('<span>'.$this->Html->image('profile.png',array('alt'=>'Edit')) . ' </span> <span class="txt"> Profile </span>', array('controller'=>'SalonStaff','action'=>'add','admin'=>true,base64_encode($user['User']['id'])) , array('title'=>'Profile','class'=>'clickable-info edit','escape'=>false) ) ?>
				    </li>
                                     <?php  $color = ($this->Common->checkStaffHours($user['User']['id']))?'gray':''; ?>
				    <li class="<?php echo $color; ?>">
					<?php echo $this->Html->link('<span>'.$this->Html->image('clock.png',array('alt'=>'Working Hours')) . ' </span> <span class="txt"> Hours </span>', array('controller'=>'Settings','action'=>'/open_hours','admin'=>true,base64_encode($user['User']['id']),'staff') , array('title'=>'Hours','class'=>'clickable-info edit','escape'=>false) ) ?>
				    </li>
                                     <?php  $color = ($this->Common->checkStaffServiceVendor($user['User']['id']))?'gray':''; ?>
				    <li class="<?php echo $color; ?>">
					<?php echo $this->Html->link('<span>'.$this->Html->image('service.png',array('alt'=>'services')) . ' </span> <span class="txt"> Service </span>', array('controller'=>'Business','action'=>'staffservices','admin'=>true,base64_encode($user['User']['id'])) , array('title'=>'Service','class'=>'clickable-info edit','escape'=>false) ) ?>
				    </li>
				    <li>
                                        <span>
                                        <?php 
                                        $booking_status = ($user['User']['booking_status'])?TRUE:FALSE;
                                        echo $this->Form->input('booking' , array('checked'=>$booking_status,'data-active-id'=>$user['User']['id'],'class'=>'custom_switch','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')); ?>
                                        </span>
                                        <span class="txt">Online Booking</span>
				    </li>
				  
				    <li class="">
					<span> <?php 
					$active_status = ($user['User']['status'])?true:false;
					echo $this->Form->input('check' , array('checked'=>$active_status,'data-active-id'=>$user['User']['id'],'class'=>'custom_switch','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini','disabled'=>TRUE)); ?>
					</span>
					<span class="txt">Active</span>  
				    </li>
				    <li class="">
				     <span class="check_alert"> 
                                       <?php 
                                           $plan = ($plan)?$plan:'no';
                                           $featured_status = ($user['User']['is_featured_employee'])?true:false;
                                           $disabled = ($user['User']['image'] && $plan)?FALSE:TRUE;
                                           echo $this->Form->input('featured', array('checked'=>$featured_status,'disabled'=>$disabled,'data-image'=>$user['User']['image'],'data-active-id'=>$user['User']['id'],'class'=>'custom_switch','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini','class'=>'alert_show','data-plan'=>$plan)); ?>
				     </span> 
				     <span class="txt">Featured Employee</span>
				    </li>
				</ul>
			    </div>
			</div>
		    </div>
	    <?php
            if(!empty($users)){
		foreach($users as $user){ ?>
		    <div class="emp-detail-box" id="<?php echo $user['User']['id']; ?>">
			<?php if($user['User']['image']){ ?>
			    <div class="emp-photo added ">
				<div class="img-change-option">
                                    <?php echo $this->Html->link('change','javascript:void(0)',array('data-div_id'=>$user['User']['id'],'class'=>'add_image')) ?>
                                    <?php echo $this->Html->link('delete','javascript:void(0)',array('data-div_id'=>$user['User']['id'], 'data-image_name'=>$user['User']['image'],'class'=>'delete_image')) ?>
				</div>
				<?php echo $this->Html->Image('/images/' . $user['User']['id'] . '/User/resized/' . $user['User']['image'],array('alt'=>'Image','title'=>'change Image')); ?>
			    </div> 
			<?php }else{ ?>    
				<a class="emp-photo add_image" data-div_id ="<?php echo $user['User']['id'] ?>"  href="javascript:void(0)">
				    <?php echo $this->Html->image('add-usephoto.png') ?>
				    <span>ADD PHOTO</span>
				</a>
			<?php } ?>
			<div class="emp-other-info">
			    <div class="emp-name-info">
				<div class="name-head">
				    <p class="staffName" ><?php echo ucfirst($user['User']['first_name'])." ".ucfirst($user['User']['last_name']); ?></p>
				    <ul>
                                    <!--<li>
                                        <a href="#">
                                            Start Calender Sharing
                                        </a>
                                    </li>
                                    <li>|</li>
                                    <li>
                                        <a href="#">Re-assign</a>
                                    </li> -->
                                    <li>
                                        <?php echo $this->Html->link('<i class="fa icon-trash"></i>','javascript:void(0)',array('class'=>'user_delete','data-salon_id'=>$admin_salon_id,'data-id'=>$user['User']['id'],'escape'=>false)); ?>
					    <a href="javascript:void(0)"></a>
                                    </li>
				    </ul>
				</div>
				<ul class="add-info">
				    <li>
					<label>Mobile 1</label>
                                        <?php if(!empty($user['Contact']['cell_phone']) && !empty($user['User']['password'])){
                                            $data_status  = 1;
                                        }else{
                                            $data_status  = 0;
                                        }
					
					
					?>
                                        <section class="ans cnt-status" >
					     <?php  echo $user['Contact']['cell_phone']; ?>
                                        </section>
				    </li>
				    <li>
					<label>E-mail</label>
					<section class="ans">
					    <?php echo $user['User']['email'];?>
					</section>
				    </li>
				    <li>
					<label>Access Level</label>
					<section class="ans">
					      <?php echo $this->Common->get_access_level_name($user['User']['group_id']); ?> 
					</section>
				    </li>
				    <li>
					<label>Pricing Level</label>
					<section class="ans">
					    <?php echo $this->Common->get_price_level_name($user['User']['id']); ?> 
					</section>
				    </li>
				</ul>
			    </div>
			    <div class="emp-extra-info">
				<ul>
                                    <?php $class = ($user['UserDetail']['employee_type']=='1' || $user['UserDetail']['employee_type']==0)?'three':''; ?>
				    <li class="gray <?php echo $class; ?>">
					<?php echo $this->Html->link('<span>'.$this->Html->image('profile.png',array('alt'=>'Edit')) . ' </span> <span class="txt"> Profile </span>', array('controller'=>'SalonStaff','action'=>'add','admin'=>true,base64_encode($user['User']['id'])) , array('title'=>'Profile','class'=>'clickable-info edit','escape'=>false) ) ?>
				    </li>
				    <?php if($user['UserDetail']['employee_type']=='2'){ ?>
				     <?php  $color = ($this->Common->checkStaffHours($user['User']['id']))?'gray':''; ?>
                                    <li class="<?php echo $color; ?>">
					<?php echo $this->Html->link('<span>'.$this->Html->image('clock.png',array('alt'=>'Working Hours')) . ' </span> <span class="txt"> Hours </span>', array('controller'=>'Settings','action'=>'/open_hours','admin'=>true,base64_encode($user['User']['id']),'staff') , array('title'=>'Hours','class'=>'clickable-info edit','escape'=>false) ) ?>
				    </li>
                                    <?php  $color = ($this->Common->checkStaffService($user['User']['id']))?'gray':''; ?>
                                    <li class="<?php echo $color; ?>">
                                        <?php
                                        echo $this->Html->link('<span>'.$this->Html->image('service.png',array('alt'=>'services')) . ' </span> <span class="txt"> Service </span>', array('controller'=>'Business','action'=>'staffservices','admin'=>true,base64_encode($user['User']['id'])) , array('title'=>'Service','class'=>'clickable-info edit','escape'=>false) ) ?>
                                    </li>
				    <li>
				    <span>
                                    <?php 
				    $booking_status = ($user['User']['booking_status'])?TRUE:FALSE;
				    echo $this->Form->input('booking' , array('checked'=>$booking_status,'data-active-id'=>$user['User']['id'],'class'=>'custom_switch','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini')); ?>
				    </span>
				    <span class="txt">Online Booking</span>
				    </li>
				    <?php } ?>
				    <li class="<?php echo $class;  ?>" >
					<span> <?php 
					$active_status = ($user['User']['status'])?true:false;
					echo $this->Form->input('check' , array('checked'=>$active_status,'data-active-id'=>$user['User']['id'],'class'=>'custom_switch manul_check','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini', 'data-manual'=>$data_status)); ?>
					</span>
					<span class="txt">Active</span>  
				    </li>
                                    <?php //if($plan!='' &&$plan!=0){ ?>
				    <li class="<?php echo $class;?>">
				     <span class="check_alert"> 
                                       <?php 
				       $plan = ($plan)?$plan:'no';
                                       $featured_status = ($user['User']['is_featured_employee'])?true:false;
                                           $disabled = ($user['User']['image'] && $plan)?FALSE:TRUE;
					echo $this->Form->input('featured', array('checked'=>$featured_status,'disabled'=>$disabled,'data-image'=>$user['User']['image'],'data-active-id'=>$user['User']['id'],'class'=>'custom_switch','hiddenField'=>false,'label'=>false,'div'=>false,'data-off-color'=>'danger','data-on-color'=>'info','type'=>'checkbox','data-size'=>'mini','class'=>'alert_show','data-plan'=>$plan)); ?>
				     </span> 
				     <span class="txt">Featured Employee</span>
				    </li>
                                    <?php //} ?>
				</ul>
			    </div>
			</div>
		    </div>
	     <?php }
	    }?>
<!--		<div class="emp-detail-box nostaffTh" >
		    <div class="emp-other-info" >
			<div class="emp-name-info" >
			    <div class="name-head"><p>No Staff Added Yet</p></div>
			</div>
		    </div>
		</div>-->
	</div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("[name='data[check]']").bootstrapSwitch();
        $("[name='data[booking]']").bootstrapSwitch();
        $("[name='data[featured]']").bootstrapSwitch();
        $('input[name="data[check]"]').on('switchChange.bootstrapSwitch', function(event, state) {
                  var theJ = $(this);
           var theId = theJ.data('active-id');
           var statusTo = state
           if($(this).data('manual')=='1'){ 
            $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'changeStatus','admin'=>true));?>",
                data: { id: theId,status:statusTo}
            })     
            }else{
                $(this).bootstrapSwitch('state', false);
            }
           
        });
        
        $('.alert_show').parent('.bootstrap-switch-container').parent('.bootstrap-switch').parent('span.check_alert').on('click', function(){
            if($(this).find('input[name="data[featured]"]').data('image')=='' || $(this).find('input[name="data[featured]"]').data('plan')=='no'){
          
            if($(this).find('input[name="data[featured]"]').data('image')==''){    
                        alert('Employee Display Picture is required to make them featured!!');
                    }else{
                        alert('Please Upgrade your plan to make your emplyees featured!!');
                }
            }
        })
        
        $('.manul_check').parent('.bootstrap-switch-container').parent('.bootstrap-switch').parent('span').on('click', function(){
            if($(this).find('input[name="data[check]"]').data('manual')==''){
                alert('Please complete the employess details first!!'); 
                }
        })
        
        
        
         $('input[name="data[booking]"]').on('switchChange.bootstrapSwitch', function(event, state) {
           var theJ = $(this);
           var theId = theJ.data('active-id');
           var statusTo = state
           $.ajax({
                type: "POST",
                url: "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'changeBookingStatus','admin'=>true));?>",
                data: { id: theId, status: statusTo}
            })
        });
        
          $('input[name="data[featured]"]').on('switchChange.bootstrapSwitch', function(event, state){
                if(!$(this).data('image') || $(this).data('plan')=='no'){ 
                  $(this).bootstrapSwitch('state', false);
                }else{
                var theJ = $(this);
                var theId = theJ.data('active-id');
                var statusTo = state
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'changeFeaturedStatus','admin'=>true));?>",
                    data: { id: theId, status: statusTo}
                })  
                }
            });
        
        $(document).on('click','.delete_image',function(){
              var theJ = $(this);
//              alert(theJ.parent().parent().next().find('input[name="data[featured]"]').data('image'));
              var theId = theJ.data('div_id');
              var theImage = theJ.data('image_name');
              if(confirm('Are you sure, you want to delete profile image?')){
                $.ajax({
                  type: "POST",
                  url: "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'deleteImage','admin'=>true));?>",
                  data: { id: theId,image:theImage},
                  success:function(response){
                    theJ.parent().parent().next().find('input[name="data[featured]"]').bootstrapSwitch('state', false);
                    window.location.reload();
                  }
              })
            }
        })
        
        var $modal = $('#commonSmallModal');
        $(document).on('click','.add_image' ,function(){
            var itsId = $(this).data('div_id');
            var addeditURL = "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'addImage')); ?>";
            addeditURL = addeditURL+'/'+itsId
            fetchModal($modal,addeditURL);
        });

         $(document).on('click', '.update_image', function(){
            var options = { 
                success:function(res){
                    // onResponse function in modal_common.js
                    if(onResponse($modal,'User',res,true)){
                        window.location.reload();
                    }
                }
            }
            
            $('#UserAdminAddImageForm').submit(function(){
                 jQuery("#UserAdminAddImageForm").validate(
              {
                onkeyup: function (element, event)
                        {
                            this.element(element);
                        },
                errorElement: "span",
                rules:{	                 
                        "data[User][image]":{
                            required: true,
                            accept:"jpg,png,jpeg,gif"
                        },
                     },
                messages: {
                    "data[User][image]":{
                        required: "<?php echo __('This field is required!'); ?>",
                        accept: "<?php echo __('Only image type jpg/png/jpeg/gif is allowed'); ?>"
                    },
                },
             }); 
                if($('#UserAdminAddImageForm').valid()){
                    $(this).ajaxSubmit(options);
		 }
                $(this).unbind('submit');
                $(this).bind('submit');
                return false;
            });
        }); 
        
/***********************delete User***********************************/
        $(document).on('click','.user_delete',function(){
        var theJ = $(this);
	    var theId = theJ.data('id');
	    var salon_id = theJ.data('salon_id');
	    if(confirm('Are you sure, you want to delete this staff?')){
                $.ajax({
                  type: "POST",
                  url: "<?php echo $this->Html->url(array('controller'=>'SalonStaff','action'=>'deleteUser','admin'=>true,'escape'=>TRUE));?>",
                  data: { id: theId,salon_id:salon_id},
                  success:function(response){
		    response = $.trim(response);
		    if(response==theId){
		     $('#'+response).remove();
		    }else{
		     alert(response);
		    }
                 }
            })
            }
        });
        
        $(document).on('keyup','.searchStaff',function(){
            var elmt = $(this);
            var value = elmt.val().toLowerCase();
            var count = 0;
            var totalShow = 0;
            var totalhidden = 0;
            var thePath = $(document).find('div.staff-content');
            thePath.find("div.nostaffTh").remove();
            thePath.find("div.emp-detail-box").each(function() {
                var text = $(this).find('p.staffName').text();
                if (text.toLowerCase().indexOf(value) >= 0) {
                    totalShow++;
                    $(this).show('slow');
                } else {
                    totalhidden++;
                    $(this).hide('slow');
                }
                count++;
            });
            if(totalShow == 0 ){
                thePath.append('<div class="emp-detail-box nostaffTh" ><div class="emp-other-info" ><div class="emp-name-info" ><div class="name-head"><p>No Search Result Found</p></div></div></div></div>')   
            }
        });
     $('#search').blur(function(e){
       $('.search').removeClass('purple-bod');
     });
      $('#search').focusin(function(e){
       $('.search').addClass('purple-bod');
     })   
        
        
 }); 
</script>