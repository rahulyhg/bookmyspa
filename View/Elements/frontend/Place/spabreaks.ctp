 
<?php
$this->Paginator->options(array( 'update' => '#update_ajax', 'evalScripts' => true/*,
        'before' => $this->Js->get('#paginated-content-container')->effect('fadeIn', array('buffer' => false)),
        'success' => $this->Js->get('#paginated-content-container')->effect('fadeOut', array('buffer' => false))*/
    ));
    ?>
<div class="wrapper">
    <div class="container clearfix">
    <!--feature deals starts-->
    <div class="featured-deals-box only-deals clearfix">
      <div class="deal-box-outer clearfix">
         <?php
            if(count($breaks) > 0){
	    foreach($breaks as $break){?>
            <div class="big-deal">
	   
                <div class="photo-sec">
                <?php echo $this->Html->image($this->Common->getspabreakImage($break['SalonSpabreakImage'][0]['spabreak_id'],$break['SalonSpabreakImage'][0]['created_by'],350),array('class'=>" ")); ?>
                </div>
                <div class="detail-area">
                    <div class="heading">
                        <?php
                            $lang = Configure::read('Config.language');
                            echo $break['Spabreak'][$lang.'_name'];
                         ?>

                        <!--<ul class="rating">
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                            <li><i class="fa fa-star"></i></li>
                        </ul>-->
                    </div>
                    <div class="add">
                        <span>
                             <?php
                                    $spaBreakPrice = $this->Common->get_spabreakPrice($break['Spabreak']['id']);
                            
                                    if($spaBreakPrice['from']){
                                        echo 'from AED '.$spaBreakPrice['full'].'';
                                    }
                                    elseif($spaBreakPrice['sell']){
                                        echo '<span class="fullPrice" >AED'.$spaBreakPrice['full'].' </span><b> AED '.$spaBreakPrice['sell'].'</b>';
                                    }
                                    else{
                                        echo 'AED '. $spaBreakPrice['full'];
                                    }
                            
                            ?>
                        </span>
                    </div>
                    <div class="clearfix">
                        <button type="button" data-id="<?php echo $break['Spabreak']['id']; ?>" class="book-now forBooking" ><?php if($break['SalonServiceDetail']['sold_as']=='2'){ echo (__('Buy Evoucher',true)); }else{ echo (__('book_now',true)); } ?></button>
                    </div>      
                    
                </div>
            </div> 
          
            <?php }}else{?>
	      <div class="not_found">Current the business is not running any spabreak.</div>
	    <?php } ?>
	</div>
    </div>
    <!--feature deals ends-->
    <div class="pdng-lft-rgt35 clearfix">
	<nav class="pagi-nation">
		<?php if($this->Paginator->param('pageCount') > 1){
			echo $this->element('pagination-frontend');
			echo $this->Js->writeBuffer();
		} ?>
	</nav>
    </div>
    </div>
</div>  