    <?php    
        echo $this->Html->script('fancybox/jquery.fancybox');
        echo $this->Html->css('fancybox/jquery.fancybox');
		echo $this->Html->script('admin/admin_user_list');
    ?>   
    
    <?php
        $recordExits = false;  
        /*echo "<pre>";
        print_r($getData);          
        die;*/
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }
        echo $this->Form->create('Search', array('id'=>'userId','type'=>'get'));  ?>
		<?php echo $this->Form->hidden('alphabet_letter',array('id'=>'hiddenalpha')); ?>
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
				 <span class="blue">(<b>Search by:</b>First Name, Last Name)</span>
            </div>
           
            <div class="col-lg-2">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
				<?php echo $this->Html->link('List All',array('controller'=>'payments','action'=>'revenue_index'),array('class' => 'btn btn-default'));?>
            </div>
            
        </div>
		
        <?php echo $this->Form->end(); ?>
		
    <div class="row">
        <div class="col-lg-12">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
     <?php echo $this->Form->create('Payment', array('id'=>'UserFormId'));  ?>
    
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
              <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('name', 'Publisher Name'); ?></th>
                            <th><?php echo $this->Paginator->sort('user_view_count', 'Post Views'); ?></th>
                            <th><?php echo $this->Paginator->sort('user_revenue', 'Revenue'); ?></th>                            
                            <th class="th_checkbox">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="dyntable">
 <?php if($recordExits)
                { ?>                       
 <?php
                        $i = 0;
                        foreach($getData as $key => $getData)
                        {
                            $class = ($i%2 == 0) ? ' class="active"' : '';
                            ?>
                        <tr <?php echo $class;?>>
                        
                            <!--<td><?php //echo $this->Html->link($getData['Payment']['user_id'],"/admin/users/addedit/".base64_encode($getData['Payment']['id']),array('escape' =>false)); ?></td>-->
                            <td><?php echo $getData[0]['name']; ?></td>
                          
                            <td><?php echo $getData['0']['user_view_count'];?></td>
                            
			    
                            <td>$<?php echo number_format($getData['0']['user_revenue'], 2, '.', '');?></td>                      
                            <td align="center">
                            <?php
                                echo $this->Html->link('View Details',"/admin/payments/user_posts/".base64_encode($getData['User']['id']),array('escape' =>false));
				//echo ($getData['Payment']['status'] == 1) ? 'Paid' : $this->Html->link('Pay Now',PAYPAL_REDIRECT_URL ."_ap-payment&paykey=".$getData['Payment']['pay_key'],array('escape' =>false));
                            ?>
                            </td>                    
                        </tr>
                        <?php
                            $i++;
                        } ?>
                    </tbody>
                </table>
                <div class="row oprdiv">
                  <div class="col-lg-12 actiondivinr"> 
                     <?php
                        if($recordExits)
                        {
                            //echo $this->element('admin/operation');  // Active/ Inactive/ Delete
                        }
                     ?>
                    </div>
                 </div>
                <div class="row">
                                      
                     <div class="col-lg-12"> <?php
                        if($this->Paginator->param('pageCount') > 1)
                        {
                            echo $this->element('admin/pagination');                 
                        }
                        ?>
                     </div>
                 </div>
              
               <?php
                }else{  ?>
              </tbody></table>
                
                <?php    echo $this->element('admin/no_record_exists');  ?>
               
                    
                    <?php } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>
