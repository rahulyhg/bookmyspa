    <?php
        echo  $this->Paginator->options(array(
        'update' => '#listview',
        'evalScripts' => true
    ));
    ?>
    
    <style>
   .search_blog_div .search-box .flag .option_wrapper {
    border-radius: 4px 0 0 4px;
    float: left;
    width: 33%;
    padding-left:5px; 
    }
    
.search_blog_div .option_wrapper, .option_wrapper select {
    height: 36px;
    line-height: 36px;
}
.search_blog_div .option_wrapper {
    background: #fff url("../../img/frontend/drop_down.png") no-repeat scroll right 0;
    border: 1px solid #cbcbcb;
    border-radius: 4px;
    cursor: pointer;
    display: block;
    font-size: 12px;
    position: relative;
    width: 100%;
}
    </style>
    
<div id="listview">
         <?php $lang =  Configure::read('Config.language'); echo $this->Form->create('Blog',array('novalidate','type' => 'file','action'=>'search'));?>
        <div class="main-search search_blog_div">
	    <div class="search-box">
		<div class="flag">
		<?php echo $this->Form->input('category',  array('div'=>false,'label'=>false,'options' => $this->common->get_list($lang.'_name'), 'empty' => 'Search By Category','class'=>'custom_option')); ?>	
		</div>
		<?php
		   $keyword =  $this->Session->read('setVar.keyword'); 
		   echo $this->Form->input('search',array('type'=>'search','label' => false,'div' => false, 'placeholder' => '','class' => '','maxlength' =>55 , 'value'=>(isset($keyword))?$keyword:''));
		?>
		 <input type="button" class='search_submit' value="Search">
	    </div>
	</div>
	
	
	<div class="wrapper">
<div class="container">
    <div class="abt-gift-voucher">
    		<!--<h2>Lorem Ipsum dummy blog title is here.</h2>-->
            <div class="blog_wrapper">
	<?php	if(!empty($allBlogs)){ 
                 foreach($allBlogs as $blog){ ?>
		    <div class="inner_blog_wrapper">
			    <div class="row">
			    <div class="col-sm-3 photo_blog">
				    <!--<img src="img/blog-2.jpg">-->
				    <?php
				    if($blog['Blog']['image'] != '')
                                   {
				      $uid = $blog['Blog']['created_by'];
				      $imagePath = '../images/'.$uid.'/Blog/350/'.$blog['Blog']['image'];
				      echo $this->Html->image($imagePath);
				    }
				   ?>
			    </div>
			    <div class="col-sm-9">
				<h3>
				    <?php echo $this->Html->link($blog['Blog'][$lang.'_title'],array('controller' => 'blogs','action'=>'view', 'full_base' => true, base64_encode($blog['Blog']['id']) , $blog['Blog']['alias'])); ?></h3>
				</h3>
				<div class="row post_by">
				    <div class="col-sm-3">
					     <i class="fa fa-calendar"></i> &nbsp;<?php echo date(DATE_FORMAT,strtotime($blog['Blog']['created'])); ?>
				     </div>
				</div>
				    <p>
				     <?php echo __(substr($blog['Blog'][$lang.'_description'] ,0, 200)); ?> </p>
				    <?php echo $this->Html->link('Read More',array('controller' => 'blogs','action'=>'view', 'full_base' => true, base64_encode($blog['Blog']['id']) , $blog['Blog']['alias']),array('class'=>'book-now')); ?>
				   <!-- <button class="book-now" type="button">Read More</button>-->
			    </div>
			</div>
		    </div>
		<?php } }else{
		echo __("No Blog found!!");	
			} ?>
		
		<div class="blog_pagination">
                    <nav>
			<?php echo $this->element('pagination'); 
			   //echo $this->Js->writeBuffer(); ?>			
		    </nav>
                </div>
            </div>
    </div>
</div>
</div> 
<script type="text/javascript">
    $(document).ready(function(){
        $(".custom_option").each(function(){
            $(this).wrap("<span class='option_wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom_option").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
	
	$('.search_submit').on('click' , function(){
	    $('#BlogSearchForm').submit();
	});
 });
</script>

	
	
<?php  echo $this->Js->writeBuffer(); ?>	
</div>




	

