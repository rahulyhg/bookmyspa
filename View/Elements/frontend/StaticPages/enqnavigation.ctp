<!--tabs main navigation starts-->
<div class="main-nav contact clearfix inner-appt">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <nav class="collapse" id="bs-example-navbar-collapse-3">
        <ul class="nav navbar">
            <li><?php echo $this->Html->link(__('Contact us',true),array('controller'=>'StaticPages','action'=>'contact_us','admin'=>false),array('class'=>($this->params['action'] == 'contact_us')?'active':'')); ?></li>
            <li><?php echo $this->Html->link(__('Business Enquiries',true),array('controller'=>'StaticPages','action'=>'business_enquiry','admin'=>false),array('class'=>($this->params['action'] == 'business_enquiry')?'active':'')); ?></li>
            <li><?php echo $this->Html->link(__('Feedback',true),array('controller'=>'StaticPages','action'=>'feedback','admin'=>false),array('class'=>($this->params['action'] == 'feedback')?'active':'')); ?></li>
        </ul>
    </nav>
</div>
<!--tabs main navigation ends-->