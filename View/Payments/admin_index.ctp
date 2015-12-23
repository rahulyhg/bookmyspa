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
        echo $this->Form->create('Search', array('url' => array('controller' => 'payments', 'action' => 'index'),'id'=>'userId','type'=>'get'));  ?>
		<?php echo $this->Form->hidden('alphabet_letter',array('id'=>'hiddenalpha')); ?>
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
				 <span class="blue">(<b>Search by:</b>First Name, Last Name, Email)</span>
            </div>
           
            <div class="col-lg-2">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
				<?php echo $this->Html->link('List All',array('controller'=>'payments','action'=>'index'),array('class' => 'btn btn-default'));?>
            </div>
            
        </div>
		
        <?php echo $this->Form->end(); ?>
		
    <div class="row">
        <div class="col-lg-12">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
     <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'payments', 'action' => 'index'),'id'=>'UserFormId'));  ?>
    
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
              <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th class="th_checkbox"><input type="checkbox" class="checkall"></th>
                            <th><?php echo $this->Paginator->sort('user_id', 'Name'); ?></th>
                            <th><?php echo $this->Paginator->sort('amount', 'Amount'); ?></th>
                            
			    
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Created'); ?> </th>                            
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
                            <td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['Payment']['id']);?>" ></td>     
                           <?php   $status = $getData['Payment']['status'];
                                    $statusImg = ($getData['Payment']['status'] == 1) ? 'active' : 'inactive';
                                    echo $this->Form->hidden('status',array('value'=>$status,'id'=>'statusHidden_'.$getData['Payment']['id'])); ?>
                            <?php  $pid = $getData['Payment']['id'];?>

                            
                            
                            <!--<td><?php //echo $this->Html->link($getData['Payment']['user_id'],"/admin/users/addedit/".base64_encode($getData['Payment']['id']),array('escape' =>false)); ?></td>-->
                            <td><?php echo $this->Html->link($getData['User']['first_name'].' '.$getData['User']['last_name'],"/admin/users/addedit/".base64_encode($getData['Payment']['id']),array('escape' =>false)); ?></td>
                          
                            <td><?php echo $getData['Payment']['amount'];?></td>
                            
			    
                            <td align="center"><?php echo ($getData['Payment']['created'] != '0000-00-00 00:00:00') ? date('M j, Y',strtotime($getData['Payment']['created'])):'N/A';?></td>                            
                            <td align="center">
                            <?php
                                echo ($getData['Payment']['status'] == 1) ? 'Paid' : 'Pending';
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
                <div class="row padding_btm_20 ">
                     <div class="col-lg-2">   
                          LEGENDS:                        
                     </div>
                     <div class="col-lg-2"><?php echo $this->Html->image("admin/delete.png"). " Delete &nbsp;"; ?></div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/edit.png"). " Edit"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/active.png"). " Active"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/inactive.png"). " Inactive"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/view.png"). " View"; ?> </div>
		            
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
