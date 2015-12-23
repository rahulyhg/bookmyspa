  <?php
	echo $this->Html->css("admin/colorpicker.css");
	echo $this->Html->script('admin/bootstrap-colorpicker.js');
  
  ?>
   <ul class="ui-form">
	   <li>
		   <label>Title and email subject *</label>
		   <section>
			   <input type="text">
		   </section>
	   </li>
	   <li>
		   <label>Recurring / Non recurring</label>
		   <section>
			   <?php
			   
			   $recurNonrecur = array('Non Recurring Email','Recurring on Last Visit','Recurring on People\'s Birthdays','Thank you email after last visit');
			   echo $this->Form->input('marketing_type',array('div'=>false,'class'=>'form-control','label'=>false,'options'=>$recurNonrecur));
			   
			   
			   ?>
		   </section>
	   </li>
   </ul>
   
   <ul class="ui-form">
	   <li>Email recipients</li>
	<!--  <li>
		   <label class="no-pdng">All customers</label>
		   <section>
			   <input type="radio" id="1">
			   <label class="new-chk" for="1">&nbsp;</label>	
		   </section>
	   </li>
	   <li>
		   <label class="no-pdng">Filtered list</label>
		   <section>	
		   <input type="radio" id="2">
			   <label class="new-chk" for="2">&nbsp;</label>	 
		   </section>
	   </li>-->
	   <li>
		   <label class="no-pdng">All customers</label>
		   <section>
		  <?php
		     $options = array('0' => '&nbsp;', '1' => '&nbsp;');
		     $attributes = array('legend' => false,'class'=>'filterCustomer','label'=>array('class'=>'new-chk no-pdng'),'separator'=>'</section></li><li><label class="no-pdng">Filtered list</label><section>','required'=>true,'default'=>'0','escape'=>false);
		     echo $this->Form->radio('email_recipients', $options, $attributes);
		  ?>
	     </section>
	   </li>
	   <li>
		   <label>Customer since</label>
		   <section>
			  <?php
			   
			   $customerSince = array('Any','Before','After');
			   echo $this->Form->input('customer_since',array('div'=>false,'class'=>'form-control','label'=>false,'options'=>$customerSince));
			   ?>
			   <span class="cal"><?php echo $this->Form->input('customer_since_date',array('div'=>false,'label'=>false)); ?><i class="fa fa-calendar"></i></span>
		   </section>
	   </li>
	   <li>
		   <label>Last visit</label>
		   <section>
			    <?php
			   
			   $lastVisit = array('Any','Before','After','Between');
			   echo $this->Form->input('last_visit',array('div'=>false,'class'=>'form-control','label'=>false,'options'=>$lastVisit));
			   ?>
			   <span class="cal"><?php echo $this->Form->input('last_visit_date',array('div'=>false,'label'=>false)); ?> <i class="fa fa-calendar"></i></span>
		   </section>
	   </li>
	   <li>
		   <label>No of appointments between</label>
		   <section>
			   <?php echo $this->Form->input('no_of_apnmnt_min',array('div'=>false,'class'=>'form-control sm','label'=>false)); ?><span class="and">And</span><?php echo $this->Form->input('no_of_apnmnt_max',array('div'=>false,'class'=>'form-control sm','label'=>false)); ?>
		   </section>
	   </li>
	   <li>
		   <label>Amount paid between</label>
		   <section>
			   <?php echo $this->Form->input('amount_paid_min',array('div'=>false,'class'=>'form-control sm','label'=>false)); ?><span class="and">And</span><?php echo $this->Form->input('amount_paid_max',array('div'=>false,'class'=>'form-control sm','label'=>false)); ?>
		   </section>
	   </li>
	   <li>
		   <label>Age between</label>
		   <section>
			   <?php echo $this->Form->input('age_between_min',array('div'=>false,'class'=>'form-control sm','label'=>false)); ?><span class="and">And</span><?php echo $this->Form->input('age_between_max',array('div'=>false,'class'=>'form-control sm','label'=>false)); ?>
		   </section>
	   </li>
	   <!--<li>
		   <label>General tag (contains)</label>
		   <section>
			   <input type="text">
		   </section>
	   </li>-->
	  <!-- <li>
		   <label>Referred by (contains)</label>
		   <section>
			   <input type="text">
		   </section>
	   </li>-->
	   <li>
		   <label>Birthday </label>
		   <section>
			    <?php
			   $birthday = array('Jan','Feb','Mar','Apr','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			   echo $this->Form->input('customer_since',array('div'=>false,'class'=>'form-control','label'=>false,'options'=>$birthday));
			   ?>
		   </section>
	   </li>
	   <li>
		   <label>Gender</label>
		   <section>
			    <?php
			   $gender = array('Any','Male','Female');
			   echo $this->Form->input('customer_since',array('div'=>false,'class'=>'form-control','label'=>false,'options'=>$gender));
			   ?>
		   </section>
	   </li>
	   <!--<li>
		   <label>Customers of</label>
		   <section>
			   <select><option></option></select>
			   <div class="sm-chk"><input type="checkbox" id="3">
			   <label for="3" class="new-chk">Include past employees</label></div>
		   </section>
	   </li>-->
	   <li>
		   <label>Services</label>
		   <section>
			   <input type="button" id = "serviceFilter" class="purple-btn pad_btn" value="Apply Service filter">
			   <div class="sm-chk">
				   <span class="block">0 customer(s) will receive email.</span>
				   <span class="block">0 customer(s) will receive email.</span>
				   <span class="block">0 customer(s) will receive email.</span>
			   </div>
		   </section>
	   </li>
   </ul>
  <!-- <ul class="ui-form email-type">
	   <li class="full-w">Email type</li>
	   <li>
		   <input type="radio" id="5">
		   <label class="new-chk"  for="5">Regular email
			   <span>Just send an email to all my customers </span>
		   </label>
	   </li>
	   
	   <li>
		   <input type="radio" id="6">
		   <label class="new-chk"  for="6">Promotional email
			   <span>Promotion emails will be sent to all your existing customers. 
			   Promotion will show on your vagaro page or vagaro website. 
			   Promotion icon will show on all the listing pages. 
			   Promotion will be accessible from the home page through our 
			   "special promotions" button. 
			   Promotion can be optionally posted on social channels, such as 
			   Facebook.  </span>
		   </label>
	   </li>
   </ul>-->
   <div class="preview-design-box">
       <label>Design</label>
       <select class="custom_option">
	   <option>Basic &amp; clean</option>
	    <option> Options </option>
	    <option> Options </option>
       </select>
       </div>
	   
	   <div class="img-scroll-box wid_mar">
		   <div class="outer-img-box">
		   <a href="#" class="lft-aro"><img src="" alt="" title=""></a>
		   <ul>
			   <li><a href="#" class="active"><img src="../../img/admin/wally1.jpg" alt="" title=""></a></li>
			   <li><a href="#"><img src="../../img/admin/wally2.jpg" alt="" title=""></a></li>
			   <li><a href="#"><img src="../../img/admin/wally3.jpg" alt="" title=""></a></li>
			   <li><a href="#"><img src="../../img/admin/wally4.jpg" alt="" title=""></a></li>
			   <li><a href="#"><img src="../../img/admin/wally5.jpg" alt="" title=""></a></li>
			   <li><a href="#"><img src="../../img/admin/wally6.jpg" alt="" title=""></a></li>
		   </ul>
		   <a href="#" class="rgt-aro"><img src="" alt="" title=""></a>
		   </div>
	   </div>
   
   
<!--   <div class="editor-box">
	   <div class="inner-edit-box">
		   <button type="button" class="upload-btn"><i class="fa fa-upload"></i> Upload background</button>
		   <div class="rgt-ad-box">
			   <div class="advertisement">
				   <img src="../../img/admin/banner-ad.jpg" alt="" title="">
			   </div>
			   <a class="fb-btn" id="facebook" href="#">Facebook</a>
			   <a class="google-btn" id="facebook" href="#">Google</a>
			   <a class="tweet-btn" id="facebook" href="#">Twitter</a>
			   <a class="youtube-btn" id="facebook" href="#">Youtube</a>
			   <a class="linkedin-btn" id="facebook" href="#">Linkedin</a>
			   <a class="myspace-btn" id="facebook" href="#">My Space</a>
		   </div>
		   <div class="lft-edit-box">
			   <div class="editor-top">
				   <label>Select Deals</label>
				   <select class="custom_option">
					   <option>Deep tissue massage deal, Full body sp...</option>
					    <option> Options </option>
					    <option> Options </option>
				   </select>
			   </div>
		   </div>		
	   </div>
	   <div class="foot-sec">
		   <ul>
			   <li><button type="button" class="editor-btn"><i class="fa  fa-pencil-square"></i> Design</button></li>
			   <li><button type="button" class="editor-btn"><i class="fa   fa-code"></i> Html</button></li>
			   <li><button type="button" class="editor-btn"><i class="fa  fa-search-plus"></i> Preview</button></li>
		   </ul>
	   </div>
   </div>-->
   
   <div class="editor-box wid_mar mar_btm">
   		<!--<a href="#"><img src="/images/Service/350/spa1.png" alt=""/></a>-->	
        <a href="#"><img src="/app/webroot/img/spa1.png" alt=""/></a>
   </div>
   <div class="mid-content">
       <div class="left-panel">
       	<textarea rows="30" cols="10"></textarea>
       </div>
       <div class="right-panel">
       		<span>
            	<b>NAME</b><br>
                Lorem Ipsum<br>
                Lorem ipsum
                <a href="#"><img src="/app/webroot/img/spa3.jpg" alt=""/></a>
            </span>
            
            <div class="spa_images">
          		<a href="#"><img src="/app/webroot/img/facebook.png" alt=""/></a>
                <a href="#"><img src="/app/webroot/img/twitter.png" alt=""/></a>
                <a href="#"><img src="/app/webroot/img/spa_youtube.png" alt=""/></a>
                <a href="#"><img src="/app/webroot/img/spa_myspace.png" alt=""/></a>
                <a href="#"><img src="/app/webroot/img/spa_linkdin.png" alt=""/></a>
                <a href="#"><img src="/app/webroot/img/spa_yelp.png" alt=""/></a>
                <a href="#"><img src="/app/webroot/img/spa_blog.png" alt=""/></a>
                
          	</div>
       </div>
   </div> 
   
   <div class="mar_btm wid_mar">
   		 <a href="#"><img src="/app/webroot/img/spa2.png" alt=""/></a>
   </div>   
   
   <ul class="ui-form color-picker">
	   <li>
		   <label>Email main Background color:</label>
		   <section>
			<?php echo $this->Form->input('main_background_color',array('div'=>false,'class'=>'form-control sm colorp','placeholder'=>"#fff",'label'=>false)); ?>
		   </section>
	   </li>
	   <li>
		   <label>Email content Background color:</label>
		   <section>
			   <?php echo $this->Form->input('content_background_color',array('div'=>false,'class'=>'form-control sm colorp','placeholder'=>"#fff",'label'=>false)); ?>
		   </section>
	   </li>
   </ul>
   
   <ul class="ui-form color-picker bod-non">
	   <li>Promotion Approval</li>
	   <li>
		   <label>See the email preview</label>
		   <section class="btns-preview">
			  
			   <?php
				echo $this->Form->button('Preview', array(
				    'type' => 'button', 'label' => false, 'div' => false,
				    'class' => 'purple-btn',
				));
				echo $this->Form->button('Send Preview Email', array(
					'type' => 'button', 'label' => false, 'div' => false,
					'class' => 'purple-btn',
				 ));
			    ?>
		   </section>
	   </li>
	   <li>
		   <section class="full-w">
		   <input type="checkbox" id="10">
		   <label class="new-chk" for="10">I acknowledge that I have reviewed all the changes to be accurate and that I understand that once I press the "Announce" button below, emails will be sent out and I will not be able to make any further modifications. </label>
		   </section>
	   </li>
	   <li>
		   <label>&nbsp;</label>
		   <section class="btns-preview">
			   <button type="button" class="purple-btn ">Safe Draft</button>
			   <button type="button" class="purple-btn">Announce</button>
			   <button type="button" class="gray-btn">Cancel</button>
		   </section>
	   </li>
   </ul>
   
   
   </div>
   
   <script>
	$(document).ready(function(){
		// -----------if "All Customer" selected disable filters---------
		$("#customer_since,#customer_since_date,#last_visit,#last_visit_date,#no_of_apnmnt_min,#no_of_apnmnt_max,#amount_paid_min,#amount_paid_max,#age_between_min,#age_between_max").attr("disabled","disabled");
		$("#serviceFilter").addClass('disabled');
		$(".filterCustomer").on('change',function(){
			var filterval = $(this).val();
			if (filterval==0) {
				$("#customer_since,#customer_since_date,#last_visit,#last_visit_date,#no_of_apnmnt_min,#no_of_apnmnt_max,#amount_paid_min,#amount_paid_max,#age_between_min,#age_between_max").attr("disabled","disabled");
				$("#serviceFilter").addClass('disabled');
			}else{
				$("#customer_since,#customer_since_date,#last_visit,#last_visit_date,#no_of_apnmnt_min,#no_of_apnmnt_max,#amount_paid_min,#amount_paid_max,#age_between_min,#age_between_max").removeAttr("disabled");
				$("#serviceFilter").removeClass('disabled');
			}
		});
		//---------------------------------------------------
		
		
		$(".colorp").colorpicker();
	});
   </script>