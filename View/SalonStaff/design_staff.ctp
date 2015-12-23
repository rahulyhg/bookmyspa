                            <?php $notifications =array();
                            $notifications =  $this->Common->notifications(); 
                            ?>
<!--                            <a href="javascript:void(0);" class='dropdown-toggle' data-toggle="dropdown">
				<img src="/img/notification.png" alt="" title="">
                            </a>
					<ul class="dropdown-menu pull-right">-->
                                        <li>
                                            <span class="heading">You have <?php echo $notifications['total'];  ?> new notifications</span>
                                        </li> 
                                        <?php foreach($notifications['notifications'] as $notification){
                                            $label = '';
                                            switch ($notification['UserNotification']['notification_type']){
                                                    case 1:
                                                        $label = "has added new customer";
                                                        break;
                                                    case 2:
                                                        $label = "has added new staff";;
                                                        break;
                                                    case 3:
                                                        $label = "has added new service";
                                                        break;
                                                    default:
                                                        $label = '';
                                                } 
                                            ?>
                                      <?php echo $label;   ?>  
                                        <li>
					    <a href="javascript:void(0)">
						<span class="notification-icon">
						<?php echo $notification['NotificationBy']['first_name'].' '.$notification['NotificationBy']['last_name']  ?>&nbsp;&nbsp;<i class="fa fa-plus"></i>&nbsp;&nbsp;
						</span>
                                                <span class="m-left-xs"> <?php echo $label;  ?> to saloon <?php echo $this->Common->get_salon_name($notification['NotificationBy']['id']); ?> </span>
						<span class="time text-muted">
                                                    <?php echo $this->Common->getTimeDifference($notification['UserNotification']['created']); ?>
                                                </span>
					    </a>
					</li>
                                        <?php } ?>
					<li>
					    <a href="#">
						<span class="notification-icon">
						    <i class="fa fa-plus"></i>&nbsp;&nbsp;
						</span>
						<span class="m-left-xs">New user registration.</span>
						<span class="time text-muted">2m ago</span>
					    </a>
					</li>
					<li>
					    <a href="#">
						<span class="notification-icon">
						    <i class="fa fa-bolt"></i>&nbsp;&nbsp;
						</span>
						<span class="m-left-xs">Application error.</span>
						<span class="time text-muted">5m ago</span>
					    </a>
					</li>
					<li>
					    <a href="#">
						<span class="notification-icon">
						    <i class="fa fa-usd"></i>&nbsp;&nbsp;
						</span>
						<span class="m-left-xs">2 items sold.</span>
						<span class="time text-muted">1hr ago</span>
					    </a>
					</li>
					<li>
					    <a href="#">
						<span class="notification-icon">
						    <i class="fa fa-plus"></i>&nbsp;&nbsp;
						</span>
						<span class="m-left-xs">New user registration.</span>
						<span class="time text-muted">1hr ago</span>
					    </a>
					</li>
                                        <li>
                                            <button type="button" class="btn btn-primary">View all notifications</button>
                                        </li>
<!--                                    </ul>-->
<div class="box">
<div class="box-content side-gap no-gap">
<div class="staff-head">
	<a href="#"><img src="/img/add-emp.png" alt="" title=""> Add employee</a>
    <section class="search"><input type="search" value="Serach"><img src="/img/admin/search-icon.png" alt"" title""/></section>
</div>

<!--upload-photo popup starts-->
  	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog upload-img">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pos-lft" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h2>Upload Multiple ImageS</h2>
          </div>
          <div class="modal-body clearfix">
            <div class="clearfix drag-box">
            	<p>Drag &amp; Drop Multiple Photo</p>
                <p class="or">OR</p>
                <button type="button" class="purple-btn"><i class="fa  fa-upload"></i>Upload File</button>
            </div>
            <div class="clearfix scroll">
            	<ul class="photo-category clearfix">
                	<li>
                    	<section>
                        	<img src="/img/user.jpg" alt="" title="">
                        </section>
                        <select>
                            <option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                        </select>
                    </li>
                    <li>
                    	<section>
                        	<img src="/img/user.jpg" alt="" title="">
                        </section>
                        <select>
                        	<option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                        </select>
                    </li>
                    <li>
                    	<section>
                        	<img src="/img/user.jpg" alt="" title="">
                        </section>
                        <select>
                        	<option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                        </select>
                    </li>
                    <li>
                    	<section>
                        	<img src="/img/user.jpg" alt="" title="">
                        </section>
                        <select>
                            <option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                            <option>Add Category</option>
                        </select>
                    </li>
                </ul>
            </div>
            
          </div>
          
          <div class="modal-footer">
         	<input type="button" name="next" class="purple-btn" value="Submit" />
          </div>
        </div>
      </div>
    </div>
<!--upload-photo popup ends-->


<div class="staff-content">
	<p>This is the list of users on this account. You can turn on/off online booking, edit profiles,
service hours/menu, and activate each user. <a href="#">See how.</a></p>

	<div class="emp-detail-box">
    	<a class="emp-photo" href="#">
        	<img src="/img/add-usephoto.png" alt="" title="">
            <span><button data-toggle="modal" data-target="#myModal">ADD PHOTO</button></span>
        </a>
        <div class="emp-other-info">
        	<div class="emp-name-info">
            	<div class="name-head">
                	<p>Ankur Gakhar</p>
                    <ul>
                    	<li><a href="#">Start Calender Sharing</a></li>
                        <li>|</li>
                        <li><a href="#">Re-assign</a></li>
                    </ul>
                </div>
                <ul class="add-info">
                	<li>
                    	<label>Cell Phone</label>
                        <section class="ans">564-445-5678</section>
                    </li>
                    <li>
                    	<label>E-mail</label>
                        <section class="ans">ankurg@smartdatainc.net</section>
                    </li>
                    <li>
                    	<label>Access Level</label>
                        <section class="ans">Account Owner</section>
                    </li>
                    <li>
                    	<label>Pricing Level</label>
                        <section class="ans">Junior</section>
                    </li>
                </ul>
            </div>
            <div class="emp-extra-info">
            	<ul>
                	<li class="gray"><a href="#" class="clickable-info"><span><img src="/img/profile.png" alt="" title=""></span>Profile</a></li>
                    <li class="gray"><a href="#" class="clickable-info"><span><img src="/img/clock.png" alt="" title=""></span>Hours</a></li>
                    <li class="gray"><a href="#" class="clickable-info"><span><img src="/img/service.png" alt="" title=""></span>Services</a></li>
                    <li>
						<span>
						<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-mini bootstrap-switch-id-check bootstrap-switch-animate" style="width: 66px;"><div class="bootstrap-switch-container" style="width: 96px; margin-left: -32px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 32px;">ON</span><span class="bootstrap-switch-label" style="width: 32px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 32px;">OFF</span><input type="checkbox" id="check" value="1" data-size="mini" data-on-color="info" data-off-color="danger" class="custom_switch" data-active-id="205" name="data[check]"></div>
						</div>
					</span>
						Online Booking
					</li>
                    <li>
						<span>
						<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-mini bootstrap-switch-id-check bootstrap-switch-animate" style="width: 66px;"><div class="bootstrap-switch-container" style="width: 96px; margin-left: -32px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 32px;">ON</span><span class="bootstrap-switch-label" style="width: 32px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 32px;">OFF</span><input type="checkbox" id="check" value="1" data-size="mini" data-on-color="info" data-off-color="danger" class="custom_switch" data-active-id="205" name="data[check]"></div>
						</div>
					</span>
						Active
					</li>
					<li><span>
						<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-mini bootstrap-switch-id-check bootstrap-switch-animate" style="width: 66px;"><div class="bootstrap-switch-container" style="width: 96px; margin-left: -32px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 32px;">ON</span><span class="bootstrap-switch-label" style="width: 32px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 32px;">OFF</span><input type="checkbox" id="check" value="1" data-size="mini" data-on-color="info" data-off-color="danger" class="custom_switch" data-active-id="205" name="data[check]"></div>
						</div>
					</span>Feature
				  </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="emp-detail-box">
    	<div class="emp-photo added">
        	<img src="/img/user.jpg" alt="" title="">
        </div>
        <div class="emp-other-info">
        	<div class="emp-name-info">
            	<div class="name-head">
                	<p>Ankur Gakhar</p>
                    <ul>
                    	<li><a href="#">Start Calender Sharing</a></li>
                        <li>|</li>
                        <li><a href="#">Re-assign</a></li>
                    </ul>
                </div>
                <ul class="add-info">
                	<li>
                    	<label>Cell Phone</label>
                        <section class="ans">564-445-5678</section>
                    </li>
                    <li>
                    	<label>E-mail</label>
                        <section class="ans">ankurg@smartdatainc.net</section>
                    </li>
                    <li>
                    	<label>Access Level</label>
                        <section class="ans">Account Owner</section>
                    </li>
                    <li>
                    	<label>Pricing Level</label>
                        <section class="ans">Junior</section>
                    </li>
                </ul>
            </div>
            <div class="emp-extra-info">
            	<ul>
                	<li class="gray"><a href="#" class="clickable-info"><span><img src="/img/profile.png" alt="" title=""></span>Profile</a></li>
                    <li class="gray"><a href="#" class="clickable-info"><span><img src="/img/clock.png" alt="" title=""></span>Hours</a></li>
                    <li class="gray"><a href="#" class="clickable-info"><span><img src="/img/service.png" alt="" title=""></span>Services</a></li>
                    <li><span>
						<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-mini bootstrap-switch-id-check bootstrap-switch-animate" style="width: 66px;"><div class="bootstrap-switch-container" style="width: 96px; margin-left: -32px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 32px;">ON</span><span class="bootstrap-switch-label" style="width: 32px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 32px;">OFF</span><input type="checkbox" id="check" value="1" data-size="mini" data-on-color="info" data-off-color="danger" class="custom_switch" data-active-id="205" name="data[check]"></div>
						</div>
					</span>Online Booking</li>
                    <li><span>
						<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-mini bootstrap-switch-id-check bootstrap-switch-animate" style="width: 66px;"><div class="bootstrap-switch-container" style="width: 96px; margin-left: -32px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 32px;">ON</span><span class="bootstrap-switch-label" style="width: 32px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 32px;">OFF</span><input type="checkbox" id="check" value="1" data-size="mini" data-on-color="info" data-off-color="danger" class="custom_switch" data-active-id="205" name="data[check]"></div>
						</div>
					</span>Active</li>
					<li><span>
						<div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-mini bootstrap-switch-id-check bootstrap-switch-animate" style="width: 66px;"><div class="bootstrap-switch-container" style="width: 96px; margin-left: -32px;"><span class="bootstrap-switch-handle-on bootstrap-switch-info" style="width: 32px;">ON</span><span class="bootstrap-switch-label" style="width: 32px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-danger" style="width: 32px;">OFF</span><input type="checkbox" id="check" value="1" data-size="mini" data-on-color="info" data-off-color="danger" class="custom_switch" data-active-id="205" name="data[check]"></div>
						</div>
					</span>Feature</li>
                </ul>
            </div>
        </div>
    </div>
</div>

</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$(document).find(".scroll").css('height','200px');
	$(document).find(".scroll").mCustomScrollbar({
		advanced:{updateOnContentResize: true}
	});	
})
</script>