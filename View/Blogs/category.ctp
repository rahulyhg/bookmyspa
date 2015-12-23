<?php $lang =  Configure::read('Config.language'); ?>
<?php
    $this->Paginator->options(array(
	    'update' => '#update_ajax',
	    'evalScripts' => true,
	    'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
	    'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false)),
	    
	));
?>
<div class="main-nav clearfix inner-appt">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-3">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
    </button>
    <nav class="collapse" id="bs-example-navbar-collapse-3">
        <ul class="nav navbar">
	   <?php $li_class = ($category_id == 'latest') ? 'active' : '';  ?>
	    <li role="presentation" class="<?php echo $li_class; ?>">
                <?php
		
		echo $this->Js->link(__('Latest',true),'/blogs/category/latest/',array('update' => '#update_ajax'));?>
            </li>
            <?php
            foreach($categories as $category){
                $li_class = '';
		if($category['BlogCategory']['id'] == $category_id){
		    $li_class = 'active';
		}
               
            ?>
            <li role="presentation" class="<?php echo $li_class;?>">
                <?php echo $this->Js->link(__($category['BlogCategory']['eng_name'],true),'/blogs/category/'.$category['BlogCategory']['id'].'/',array('update' => '#update_ajax'));?>
            </li>
            <?php  }  ?>
            <?php
            //$li_class = '';
            //if($this->params['controller'] == 'Myaccount' && $this->params['action'] == 'orders'){
              //    $li_class = 'active';
            //}?>
            <!--<li role="presentation" class="<?php //echo $li_class;?>"> -->
            <?php //echo $this->Js->link(__('Beauty',true),'/Myaccount/orders/',array('update' => '#update_ajax'));?>
            <!--</li> -->
            <?php //$li_class = '';
            //if($this->params['controller'] == 'users'  && $this->params['action'] == 'spabreaks'){
              //    $li_class = 'active';
            //}?>
            <!--<li role="presentation" class="<?php //echo $li_class;?>"> -->
            <?php //echo $this->Js->link(__('Health Living',true),'/users/spabreaks/',array('update' => '#update_ajax'));?>
            <!--</li>-->
        </ul>
    </nav>
</div>
<div class="wrapper">
    <div class="container">
    <!--sort by ends-->
    <!--main body section-->
        <?php echo $this->element('frontend/Blog/post_list'); ?>
    </div>
</div>
<style>
    .inner-appt.main-nav nav ul li a{
	padding-left: 15px;
	padding-right: 15px;
    }
    pagi-nation col-sm-12 pull-right{
	padding:0 0 0 0 ;
    }
    .massage1{
	margin:0 0 15%;
    }
    a,a:hover{
	color:#5b3671;
    }
</style>
<!--<style>
.blog-left-side{float:left; width:880px;}
.m-bot10{margin-bottom:10px;}
.blog-tab-1{ background-color: #f5f5f5;padding: 10px;text-align: center;}
.border-r-l{border-left: 1px dashed #686868;border-right: 1px dashed #686868;}
.pdng-tp20{padding-top:20px;}
.pdng-bt40{padding-bottom:40px;}
.pdng-bt30{padding-bottom:30px;}
.brdr-btm1{border-bottom:1px solid #e1e1e1;}
.p-text{padding:5px}
.blog-tab-1 i.fa{padding-right:5px;}
</style>-->
<?php echo $this->Js->writeBuffer();?>