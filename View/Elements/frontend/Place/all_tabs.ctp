<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-salonPage-navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
</button>
<nav class="collapse" id="bs-salonPage-navbar">
<ul class="nav navbar" role="tablist">
    <li role="presentation" class="active">
        <a href="#About" aria-controls="About" role="tab" data-toggle="tab"><?php echo __('about',true);?></a>
    </li>
    <li role="presentation" class="">
        <a href="#Services" aria-controls="Services" role="tab" data-toggle="tab"><?php echo __('services',true);?></a>
    </li> 
    <li role="presentation" class="">
        <a href="#Package" aria-controls="Package" role="tab" data-toggle="tab"><?php echo __('package',true);?></a>
    </li>
    <li role="presentation">
        <a href="#SpaDay" aria-controls="SpaDay" role="tab" data-toggle="tab"><?php echo __('spa day',true);?></a>
    </li>
    <li role="presentation">
        <a href="#Deals" aria-controls="Bank" role="tab" data-toggle="tab"><?php echo __('deals',true);?> <i class="fa fa-clock-o"></i></a>
    </li>
    <li role="presentation">
        <a href="#Staff" aria-controls="Staff" role="tab" data-toggle="tab"><?php echo __('our_staff',true);?></a>
    </li>
    <li role="Advertisement">
        <a href="#Gallery" aria-controls="Ads" role="tab" data-toggle="tab"><?php echo __('gallery',true);?></a>
    </li>
    <?php if($userDetails['PolicyDetail']['enable_gfvocuher']==1){  ?>
    <li role="presentation">
        <a href="#Gifts" aria-controls="Services" role="tab" data-toggle="tab"><?php echo __('gift_certificate',true);?></a>
    </li>
    <?php } ?>
    <li role="presentation">
        <a href="#Giftsss" aria-controls="Services" role="tab" data-toggle="tab"><?php echo __('reviews',true);?></a>
    </li> 
</ul>
</nav>