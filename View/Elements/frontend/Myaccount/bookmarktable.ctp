<!-- Tab panes -->
          <div  class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="my_appointments">
	    <?php if(!empty($getSalon)){
		foreach($getSalon as $salon) {//pr($order); ?>
		    <div  class="info-box clearfix">
                	<div class="img-box">
			   <?php if($salon['Salon']['logo'] != '') {
				    if (file_exists('/images/'.$salon['User']['id'].'/User/400/'.$salon['Salon']['logo'])) {
					echo $this->Html->image('/images/'.$salon['User']['id'].'/User/400/'.$salon['Salon']['logo']);
				    } else { ?>
					<img src="/img/frontend/search-page-img.jpg" alt="" title="">
				    <?php }
				}else{ ?>
				    <img src="/img/frontend/search-page-img.jpg" alt="" title="">
				<?php } ?>
			</div>
                
                    <div class="txt-box">
                        <h2>
			  <?php echo $this->Html->link($this->Common->get_salon_name($salon['Salon']['user_id']),'/'.$salon['Salon']['business_url'],array('escape'=>false)); ?>
			</h2>
                        <p><?php echo $salon['User']['first_name'].' '.$salon['User']['last_name'];?></p>
                       
                    </div>
                    
                	
                    
                    <!--div class="btn-box">
                    	<button type="button" class="gray-btn">Cancel</button>
                        <button type="button" class="book-now">Reschedule</button>
                    </div-->
                </div>  
		    
		<?php } ?>
		 <!--div class="result_pages">
		  
		</div-->
		<?php if(count($getSalon) >= 10) { ?>
		<div class ="ck-paging">
		    <?php
		    echo $this->Paginator->first('First');
		    echo $this->Paginator->prev(
			      'Previous',
			      array(),
			      null,
			      array('class' => 'prev disabled')
		    );
		    echo $this->Paginator->numbers(array('separator'=>' '));
		    echo $this->Paginator->next(
			      'Next',
			      array(),
			      null,
			      array('class' => 'next disabled')
		    );
		    echo $this->Paginator->last('Last');?>
		</div>
		<?php } ?>
	    <?php }else{
                
                echo '<div class="no-result-found">No Result Found</div>';
            } ?>
            	
            </div>
         </div>
        
        <!--inner tabs ends-->


<style>
    .inner-loader{
	display: none;
    }
</style>